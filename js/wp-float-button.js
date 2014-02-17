(function() {
    tinymce.create('tinymce.plugins.wpfloat', {
        init : function(ed, url) {
        	ed.addCommand('wp_float_cmd', function() {
				ed.windowManager.open({
					file : url + '/button-wpfloat.php',
					width : 400 + parseInt(ed.getLang('button.delta_width', 0)),
					height : 500 + parseInt(ed.getLang('button.delta_height', 0)),
					inline : 1
					}, {
					plugin_url : url
				});
			});
    
            ed.addButton('wpfloat', {
                title : 'WP Float',
                image : url + '/wpfloat.png',
                cmd: 'wp_float_cmd'
            });
        },
		getInfo : function() {
			return {
				longname : 'WP Float',
				author : 'Sam Hagin',
				authorurl : 'http://webwiki.co',
				infourl : 'http://webwiki.co/plugins-widgets/64-wp-float-plugin',
				version : tinymce.majorVersion + '.' + tinymce.minorVersion
			};
		}
    });
    tinymce.PluginManager.add('wpfloat', tinymce.plugins.wpfloat);
})();
