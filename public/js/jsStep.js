'use strict';

function goToNextPreviousStep(type)
{
	var currentTabStepTemp=$('.ulStepActive')[0];
	var nextTabStepTemp=$(currentTabStepTemp).find('~ li')[0];
	var previousTabStepTemp=null;

	$('.ulStep > li').each(function(index, element)
	{
		if($(element).hasClass('ulStepActive') && index>0)
		{
			previousTabStepTemp=$('.ulStep > li')[index-1];
		}
	});

	var currentStepTemp=$('.divStepActive')[0];
	var nextStepTemp=$(currentStepTemp).find('~ .divStep')[0];
	var previousStepTemp=null;

	$('.divStep').each(function(index, element)
	{
		if($(element).hasClass('divStepActive') && index>0)
		{
			previousStepTemp=$('.divStep')[index-1];
		}
	});

	if(type)
	{
		if(nextTabStepTemp!=null)
		{
			$(currentTabStepTemp).removeClass('ulStepActive');
			$(nextTabStepTemp).addClass('ulStepActive');
		}

		if(nextStepTemp!=null)
		{
			$(currentStepTemp).removeClass('divStepActive');
			$(nextStepTemp).addClass('divStepActive');
		}
	}
	else
	{
		if(previousTabStepTemp!=null)
		{
			$(currentTabStepTemp).removeClass('ulStepActive');
			$(previousTabStepTemp).addClass('ulStepActive');
		}

		if(previousStepTemp!=null)
		{
			$(currentStepTemp).removeClass('divStepActive');
			$(previousStepTemp).addClass('divStepActive');
		}
	}
}