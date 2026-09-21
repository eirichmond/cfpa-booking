(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	 $(function() {

		 $('#output-options').tablesorter({
			 theme: 'bootstrap',
			 widthFixed : true,
			 headerTemplate : '{content} {icon}',
			 widgets: ["zebra", "stickyHeaders", "uitheme"]
		 });

		 $('#myTable table').tablesorter({
			 theme: 'bootstrap',
			 widthFixed : true,
			 headerTemplate : '{content} {icon}',
			 widgets: ["zebra", "filter", "uitheme", "output"],
			 widgetOptions : {
				 filter_filteredRow   : 'filtered',
				 filter_reset         : '.tablesorter .reset',
				 output_headerRows    : true,        // output all header rows (multiple rows)
				 output_popupStyle    : 'width=580,height=310',
				 output_saveFileName  : 'mytable.csv'
			 }
		 });

		 // set up download buttons for two table groups
		 var demos = ['.group1', '.tablesorter'];

		 $.each(demos, function(groupIndex){
			 var $this = $(demos[groupIndex]);

			 $this.find('.dropdown-toggle').click(function(e){
				 // this is needed because clicking inside the dropdown will close
				 // the menu with only bootstrap controlling it.
				 $this.find('.dropdown-menu').toggle();
				 return false;
			 });
			 // make separator & replace quotes buttons update the value
			 $this.find('.output-separator').click(function(){
				 $this.find('.output-separator').removeClass('active');
				 var txt = $(this).addClass('active').html()
				 $this.find('.output-separator-input').val( txt );
				 $this.find('.output-filename').val(function(i, v){
					 // change filename extension based on separator
					 var filetype = (txt === 'json' || txt === 'array') ? 'js' :
						 txt === ',' ? 'csv' : 'txt';
					 return v.replace(/\.\w+$/, '.' + filetype);
				 });
				 return false;
			 });
			 $this.find('.output-quotes').click(function(){
				 $this.find('.output-quotes').removeClass('active');
				 $this.find('.output-replacequotes').val( $(this).addClass('active').text() );
				 return false;
			 });

			 // clicking the download button; all you really need is to
			 // trigger an "output" event on the table
			 $this.find('.download').click(function(){
				 var typ,
					 $table = $this.find('table'),
					 wo = $table[0].config.widgetOptions,
					 saved = $this.find('.output-filter-all :checked').attr('class');
				 wo.output_separator    = $this.find('.output-separator-input').val();
				 wo.output_delivery     = $this.find('.output-download-popup :checked').attr('class') === 'output-download' ? 'd' : 'p';
				 wo.output_saveRows     = saved === 'output-filter' ? 'f' :
					 saved === 'output-visible' ? 'v' :
						 saved === 'output-selected' ? '.checked' : // checked class name, see table.config.checkboxClass
							 saved === 'output-sel-vis' ? '.checked:visible' :
								 'a';
				 wo.output_replaceQuote = $this.find('.output-replacequotes').val();
				 wo.output_trimSpaces   = $this.find('.output-trim').is(':checked');
				 wo.output_includeHTML  = $this.find('.output-html').is(':checked');
				 wo.output_wrapQuotes   = $this.find('.output-wrap').is(':checked');
				 wo.output_headerRows   = $this.find('.output-headers').is(':checked');
				 wo.output_saveFileName = $this.find('.output-filename').val();
				 $table.trigger('outputTable');
				 return false;
			 });

			 // add tooltip
			 //$this.find('.dropdown-menu [title]').tipsy({ gravity: 's' });

		 });
	


	 });

})( jQuery );
