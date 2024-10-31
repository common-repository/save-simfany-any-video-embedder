(function() {


	tinymce.create('tinymce.plugins.simfany', {
		init : function(ed, url) {
			

ed.addCommand('mcesimfany2', function() {
				
				ed.execCommand("mceBeginUndoLevel");
				var content = tinyMCE.activeEditor.selection.getContent({format : 'raw'});
				var newcontent = '[simfany]' + content + '[/simfany]';
                                

				tinyMCE.activeEditor.selection.setContent(newcontent);
				
				ed.execCommand("mceEndUndoLevel");

				return false;
				
			});

			// Register example button
			ed.addButton('simfany2', {
				title : 'Embed any video using Simfany',
				cmd : 'mcesimfany2',
				image : url + '/img/simfany.gif'


			});

			
		},
		createControl : function(n, cm) {
			return null;
		},
		getInfo : function() {
			return {
				longname : 'Simfany Any Video Embedder',
				author : '2by2host.com',
				authorurl : 'http://2by2host.com/hosting/wordpress/',
				infourl : 'http://simfany.com/apps.html',
				version : "1.0"
			};
		}
	});

	tinymce.PluginManager.add('simfany', tinymce.plugins.simfany);
})();
