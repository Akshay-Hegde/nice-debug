$(function(){

	function createCookie() {
		$.cookie("nice_debug", $('#codeigniter_profiler').width(), { expires : 10 });
	}

	function deleteCookie() {
		$.cookie("nice_debug", null);
	}

	function niceDebug() {
		//add inner wrapper
		$('#codeigniter_profiler').wrapInner('<div id="log"></div>');
		//add padding wrapper
		$('#log').wrapInner('<div id="log-padding" />');
		//add title
		$('#codeigniter_profiler').prepend('<div class="head-divider"></div>');
		$('#codeigniter_profiler').prepend('<span class="h1"><span class="pln">nice<span><span class="pun">::</span><span class="str">debug</span></span>');
		//add background right arrow
		$('#codeigniter_profiler').append('<div id="profiler_arrow"></div>');
		$('#profiler_arrow').append('<div id="arrow_icon"></div>');
		$('#codeigniter_profiler').append('<div id="profiler_close"></div>');
	
		//make resizeable
		$('#codeigniter_profiler').resizable({ handles:'e', ghost: true, minWidth: 380, maxWidth: ($('body').width() - 1), stop: function( event, ui ) { createCookie(); $('iframe.nice_debug_frame').show(); },  resize: function( event, ui ) { $('iframe.nice_debug_frame').hide(); } });
		//add slide in
    	$('#codeigniter_profiler #profiler_arrow').live("click", function(event){
			$('#codeigniter_profiler').animate({ 'left': '+='+($('#codeigniter_profiler').outerWidth()-10) }, 1000);
			$('#codeigniter_profiler #profiler_arrow').css("display","none");
			$('#codeigniter_profiler #profiler_close').css("display","block");
			createCookie();
    	});
    	//add slide out
    	$('#codeigniter_profiler #profiler_close').live("click", function(event){
			$('#codeigniter_profiler').animate({ 'left': '-='+($('#codeigniter_profiler').outerWidth()-10) }, 1000);
			$('#codeigniter_profiler #profiler_arrow').css("display","block");
			$('#codeigniter_profiler #profiler_close').css("display","none");
			deleteCookie();
    	});
	
    	//show or hide by default
    	if ($.cookie("nice_debug")) {
    		$('#codeigniter_profiler').width($.cookie("nice_debug"));
			$('#codeigniter_profiler').css('left', 0);
			$('#codeigniter_profiler #profiler_arrow').css("display","none");
			$('#codeigniter_profiler #profiler_close').css("display","block");
    	}
	
		//add query number count to each row
		var rowCounter = 1;
		$('#codeigniter_profiler #ci_profiler_queries_db_0 tr').each(function(){
			$(this).prepend('<td style="padding-right: 10px !important;">'+rowCounter+'</td>');
			rowCounter++;
		});	
	
		//ensure consistent style (font and background color)
		$('#codeigniter_profiler').find('td, #log-padding div, legend').css('color', '#000000').each(function( index ) {
			$(this).addClass('pln');
		});
		$('#codeigniter_profiler').find('fieldset strong').each(function( index ) {
			$(this).addClass('pln');
		});
		$('#codeigniter_profiler').find('span strong').each(function( index ) {
			$(this).addClass('pln');
		});
		$('#codeigniter_profiler').find('legend span').each(function( index ) {
			$(this).addClass('pln');
		});
	
		//trim whitespace from start and end of code blocks
		$("#ci_profiler_queries_db_0 td span").text().trim();
		$("#ci_profiler_queries_db_0 td strong").text().trim();
	
		//unwrap spans in db query (we're goig to prettyPrint it shortly)
		$('#ci_profiler_queries_db_0 td span').contents().unwrap();
		$('#ci_profiler_queries_db_0 td strong').contents().unwrap();
	
		//add prettify class to each code block
		$('#ci_profiler_queries_db_0 td code').addClass('prettyprint');	
		$('#ci_profiler_queries_db_0 td code').addClass('pln');	
		
		prettyPrint();
	
		//background color
		var backgroundColor = $('#ci_profiler_queries_db_0 .pln').first().css('backgroundColor');
		$('#codeigniter_profiler, #codeigniter_profiler td').css('backgroundColor', backgroundColor);
	
		//border color
		var borderColor = $('#ci_profiler_queries_db_0 .str').first().css('color');	
		$('#codeigniter_profiler .head-divider').css('border-top', "1px dashed " + borderColor);
	
		//text color
		var textColor = $('#ci_profiler_queries_db_0 .pln').first().css('color');	
		$('#codeigniter_profiler td', '#codeigniter_profiler .pln').css('color', textColor);
	
		//replace line breaks with a span
		$("#ci_profiler_queries_db_0 td code").each(function( index ) {
			var str = $(this).html();
			var regex = /<br\s*[\/]?>/gi;
			$(this).html(str.replace(regex, "<span class='line-break'></span>"));
		});
	
		//replace legends with h3 and remove show/hide
		$('#codeigniter_profiler legend').each(function(object){
			var titleContent = $(this).html();
			$(this).replaceWith("<span class='h3'>" + titleContent + "</span>");
		});
	
		//clean up headers
		$('#codeigniter_profiler .h3').each(function(object){
			$(this).find('span').remove();
			$(this).html($(this).html().replace(/&nbsp;/g, ' '));
			$(this).html($(this).html().replace('()', ''));
		});
	
		add_nb_iframe();

		//style the headers
		$('#codeigniter_profiler .h3').css('color', textColor);	
		$('#codeigniter_profiler .h3').css('border-bottom', "1px solid "+borderColor);	
	
		//remove fieldsets
		$('#codeigniter_profiler fieldset').each(function(object){
			var fieldsetContent = $(this).html();
			$(this).replaceWith(fieldsetContent);
		});
	
		//add wrapper to tables
		$('#codeigniter_profiler table').wrap('<div></div>');	
		//display tables (where hidden before)
		$('#codeigniter_profiler table').css('display', 'block');
		//remove width attribute from table cells
		$('#codeigniter_profiler table td').css('width', '');
		//add classes to non database query tables
		$('#codeigniter_profiler table').each(function(object){
			if ($(this).attr('id') != "ci_profiler_queries_db_0") {
				$(this).addClass('not-db');
			}
		});
	
		$( "#log-padding" ).accordion({
			heightStyle: "fill",
			animated: false
		});
	};

	if (! isInIframe) {
		niceDebug();
	} else {
		$('#codeigniter_profiler').remove();
	}

});