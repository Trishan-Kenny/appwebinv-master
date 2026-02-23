<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Session\SessionManager;
use Illuminate\Encryption\Encrypter;

use App\Validation\UsuarioValidation;

use DB;
use Mail;

use App\Model\TUsuario;
use App\Model\TOficina;
use App\Model\TUsuarioTOficina;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    public function actionInsertar(Request $request, SessionManager $sessionManager, Encrypter $encrypter)
    {
        if ($_POST) {
            try {
                DB::beginTransaction();

                $this->mensajeGlobal = (new UsuarioValidation())->validationInsertar($request);

                if ($this->mensajeGlobal != '') {
                    DB::rollBack();

                    $request->flash();

                    return $this->plataformHelper->redirectError($this->mensajeGlobal, 'usuario/insertar');
                }

                $tUsuario = new TUsuario();

                $tUsuario->codigoUsuario = uniqid();
                $tUsuario->dni = trim($request->input('txtDni'));
                $tUsuario->nombre = trim($request->input('txtNombre'));
                $tUsuario->apellido = trim($request->input('txtApellido'));
                $tUsuario->correoElectronico = trim($request->input('txtCorreoElectronico'));
                $tUsuario->contrasenia = $encrypter->encrypt($request->input('passContrasenia'));
                $tUsuario->rol = strpos($sessionManager->get('rol'), 'Súper usuario') !== false ? ($request->input('selectRol') == null || $request->input('selectRol') == '' ? '' : implode(',', $request->input('selectRol'))) : 'Usuario general';
                $tUsuario->estado = (strpos($sessionManager->get('rol'), 'Súper usuario') !== false || strpos($sessionManager->get('rol'), 'Administrador') !== false) ? 'Activo' : 'Pendiente';

                $tUsuario->save();

                $tUsuarioTOficina = new TUsuarioTOficina();

                $tUsuarioTOficina->codigoUsuarioTOficina = uniqid();
                $tUsuarioTOficina->codigoUsuario = $tUsuario->codigoUsuario;
                $tUsuarioTOficina->codigoOficina = TOficina::first()->codigoOficina;

                $tUsuarioTOficina->save();

                DB::commit();

                try {
                    $tUsuarioParaCorreo = TUsuario::first();

                    $mensajeCorreo = 'Se ha registrado un nuevo usuario en el sistema MPPJA, por lo que requiere verificación de datos para su activación.';

                    Mail::send('email.mensajegeneral', ['nombreReceptor' => $tUsuarioParaCorreo->nombre, 'mensajeCorreo' => $mensajeCorreo], function ($x) use ($tUsuarioParaCorreo) {
                        $x->from(config('var.MAIL_USERNAME'), config('var.URL_GENERAL_SHOW'));
                        $x->to($tUsuarioParaCorreo->correoElectronico, ($tUsuarioParaCorreo->nombre) . ' ' . ($tUsuarioParaCorreo->apellido))->subject('Verificación de registro de usuario');
                    });
                } catch (\Exception $ex) {
                }

                return $this->plataformHelper->redirectCorrecto('Operación realizada correctamente.', 'usuario/graciasregistro');
            } catch (\Exception $e) {
                DB::rollback();

                return $this->plataformHelper->capturarExcepcion(__CLASS__, __FUNCTION__, $e->getMessage(), '/');
            }
        }

        return view('usuario/insertar');
    }

    public function actionGraciasRegistro()
    {
        return view('usuario/graciasregistro');
    }

    public function actionVer()
    {
        $listaTUsuario = TUsuario::whereRaw('rol not like ? order by case when estado=? then 1 else (case when estado=? then 2 else 3 end) end', ['%Súper usuario%', 'Pendiente', 'Activo'])->get();

        return view('usuario/ver', ['listaTUsuario' => $listaTUsuario]);
    }

    public function actionLogIn(Request $request, SessionManager $sessionManager, Encrypter $encrypter)
    {
        if ($_POST) {
            $sessionManager->flush();
            
            $correoElectronicoTemp = trim($request->input('txtCorreoElectronico'));
            $codigoOficinaTemp = $request->input('selectCodigoOficina');
            $tUsuario = TUsuario::with(['tusuariotoficina' => function ($q) use ($codigoOficinaTemp) {
                $q->whereRaw('codigoOficina=?', [$codigoOficinaTemp]);
            }])->whereRaw('correoElectronico=?', [trim($request->input('txtCorreoElectronico'))])->first();

            if ($tUsuario != null && (count($tUsuario->tusuariotoficina) > 0 || strpos($tUsuario->rol, 'Súper usuario') !== false)) {
                if ($tUsuario->estado == 'Pendiente') {
                    return $this->plataformHelper->redirectError('Su usuario aún se encuentra en revisión. Se le notificará a su correo cuando hayamos verificado sus datos.', 'usuario/login');
                }

                if ($tUsuario->estado == 'Bloqueado') {
                    return $this->plataformHelper->redirectError('Acceso imposible debido a que su usuario fue bloqueado.', 'usuario/login');
                }
                
                if ($encrypter->decrypt($tUsuario->contrasenia) == $request->input('passContrasenia')) {
                    $sessionManager->put('codigoUsuario', $tUsuario->codigoUsuario);
                    $sessionManager->put('dni', $tUsuario->dni);
                    $sessionManager->put('correoElectronico', $tUsuario->correoElectronico);
                    $sessionManager->put('nombreCompleto', $tUsuario->nombre);
                    $sessionManager->put('rol', $tUsuario->rol);
                    $sessionManager->put('codigoOficina', $request->input('selectCodigoOficina'));
                    $sessionManager->put('nombreOficina', TOficina::find($request->input('selectCodigoOficina'))->nombre);

                    return $this->plataformHelper->redirectCorrecto('Se bienvenido(a) al sistema, ' . $tUsuario->nombre . '.', 'general/indexadmin');
                }
            }

            return $this->plataformHelper->redirectError('Datos de usuario incorrecto o no tiene permiso para acceder a esta oficina.', 'usuario/login');
        }

        $listaTOficina = TOficina::all();

        return view('usuario/login', ['listaTOficina' => $listaTOficina]);
    }

    public function actionLogOut(SessionManager $sessionManager)
    {
        $sessionManager->flush();

        return $this->plataformHelper->redirectCorrecto('Sesión cerrada correctamente.', 'general/indexadmin');
    }

    public function actionEditar(Request $request, SessionManager $sessionManager)
    {
        if ($request->has('hdCodigoUsuario')) {
            try {
                DB::beginTransaction();

                $tUsuario = TUsuario::whereRaw('codigoUsuario=?', [$request->input('hdCodigoUsuario')])->first();

                if (strpos($sessionManager->get('rol'), 'Administrador') === false && strpos($sessionManager->get('rol'), 'Súper usuario') === false && !($this->plataformHelper->verificarExistenciaAutorizacion($tUsuario, 'codigoUsuario', $sessionManager->get('codigoUsuario'), $mensajeOut))) {
                    return $this->plataformHelper->redirectError($mensajeOut, 'usuario/ver');
                }

                $this->mensajeGlobal = (new UsuarioValidation())->validationEditar($request);

                if ($this->mensajeGlobal != '') {
                    DB::rollBack();

                    return $this->plataformHelper->redirectError($this->mensajeGlobal, 'usuario/ver');
                }

                $estadoTemporal = $tUsuario->estado;

                $tUsuario->dni = trim($request->input('txtDni'));
                $tUsuario->nombre = trim($request->input('txtNombre'));
                $tUsuario->apellido = trim($request->input('txtApellido'));
                $tUsuario->correoElectronico = trim($request->input('txtCorreoElectronico'));
                $tUsuario->rol = $request->input('selectRol') == null || $request->input('selectRol') == '' ? '' : implode(',', $request->input('selectRol'));
                $tUsuario->estado = $request->input('selectEstado');

                $tUsuario->save();

                DB::commit();

                if ($estadoTemporal != $request->input('selectEstado')) {
                    try {
                        $tUsuarioParaCorreo = $tUsuario;

                        $mensajeCorreo = 'Se le informa que el estado de su usuario en el sistema MPPJA ha sido cambiado a <b>"' . $request->input('selectEstado') . '"</b>.';

                        Mail::send('email.mensajegeneral', ['nombreReceptor' => $tUsuarioParaCorreo->nombre, 'mensajeCorreo' => $mensajeCorreo], function ($x) use ($tUsuarioParaCorreo) {
                            $x->from(config('var.MAIL_USERNAME'), config('var.URL_GENERAL_SHOW'));
                            $x->to($tUsuarioParaCorreo->correoElectronico, ($tUsuarioParaCorreo->nombre) . ' ' . ($tUsuarioParaCorreo->apellido))->subject('Verificación de registro de usuario');
                        });
                    } catch (\Exception $ex) {
                    }
                }

                return $this->plataformHelper->redirectCorrecto('Operación realizada correctamente.', 'usuario/ver');
            } catch (\Exception $e) {
                DB::rollback();

                return $this->plataformHelper->capturarExcepcion(__CLASS__, __FUNCTION__, $e->getMessage(), '/');
            }
        }

        $tUsuario = TUsuario::whereRaw('codigoUsuario=?', [$request->input('codigoUsuario')])->first();

        if (strpos($sessionManager->get('rol'), 'Administrador') === false && strpos($sessionManager->get('rol'), 'Súper usuario') === false && !($this->plataformHelper->verificarExistenciaAutorizacion($tUsuario, 'codigoUsuario', $sessionManager->get('codigoUsuario'), $mensajeOut))) {
            return $this->plataformHelper->redirectError($mensajeOut, 'usuario/ver');
        }

        return view('usuario/editar', ['tUsuario' => $tUsuario]);
    }

    public function actionCambiarContrasenia(Request $request, SessionManager $sessionManager, Encrypter $encrypter)
    {
        if ($request->has('hdCodigoUsuario')) {
            try {
                DB::beginTransaction();

                $tUsuario = TUsuario::whereRaw('codigoUsuario=?', [$request->input('hdCodigoUsuario')])->first();

                if (strpos($sessionManager->get('rol'), 'Administrador') === false && strpos($sessionManager->get('rol'), 'Súper usuario') === false && !($this->plataformHelper->verificarExistenciaAutorizacion($tUsuario, 'codigoUsuario', $sessionManager->get('codigoUsuario'), $mensajeOut))) {
                    return $this->plataformHelper->redirectError($mensajeOut, 'usuario/ver');
                }

                if ($encrypter->decrypt($tUsuario->contrasenia) != $request->input('passContraseniaActual') && strpos($sessionManager->get('rol'), 'Administrador') === false && strpos($sessionManager->get('rol'), 'Súper usuario') === false) {
                    return $this->plataformHelper->redirectError('La contraseña actual no es la correcta.', 'usuario/ver');
                }

                $tUsuario->contrasenia = $encrypter->encrypt($request->input('passContrasenia'));

                $tUsuario->save();

                DB::commit();

                return $this->plataformHelper->redirectCorrecto('Operación realizada correctamente.', 'usuario/ver');
            } catch (\Exception $e) {
                DB::rollback();

                return $this->plataformHelper->capturarExcepcion(__CLASS__, __FUNCTION__, $e->getMessage(), '/');
            }
        }

        $tUsuario = TUsuario::whereRaw('codigoUsuario=?', [$request->input('codigoUsuario')])->first();

        if (strpos($sessionManager->get('rol'), 'Administrador') === false && strpos($sessionManager->get('rol'), 'Súper usuario') === false && !($this->plataformHelper->verificarExistenciaAutorizacion($tUsuario, 'codigoUsuario', $sessionManager->get('codigoUsuario'), $mensajeOut))) {
            return $this->plataformHelper->redirectError($mensajeOut, 'usuario/ver');
        }

        return view('usuario/cambiarcontrasenia', ['tUsuario' => $tUsuario]);
    }
}