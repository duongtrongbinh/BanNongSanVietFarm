
var route_prefix = "/filemanager";

let editor_config = {
  path_absolute : "/",
  selector: 'textarea.my-editor-tinymce4',
  relative_urls: false,
  plugins: [ 'advlist', 'autolink', 'link', 'image', 'lists', 'charmap', 'preview','table' ],
  toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media | image | table tabledelete | tableprops tablerowprops tablecellprops | tableinsertrowbefore tableinsertrowafter tabledeleterow | tableinsertcolbefore tableinsertcolafter tabledeletecol",
  file_picker_callback : function(callback, value, meta) {
    let x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
    let y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;

    let cmsURL = editor_config.path_absolute + 'filemanager?editor=' + meta.fieldname;
    if (meta.filetype == 'image') {
      cmsURL = cmsURL + "&type=Images";
    } else {
      cmsURL = cmsURL + "&type=Files";
    }

    tinyMCE.activeEditor.windowManager.openUrl({
      url : cmsURL,
      title : 'Filemanager',
      
      width : x * 0.8,
      height : y * 0.8,
      resizable : "yes",
      close_previous : "no",
      onMessage: (api, message) => {
        callback(message.content);
      }
    });
  }
};

tinymce.init(editor_config);

    var editor_confihg = {
      path_absolute : "",
      selector: "textarea[name=tm]",
      plugins: [
        "link image"
      ],
      relative_urls: false,
      height: 129,
      file_browser_callback : function(field_name, url, type, win) {
        var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
        var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;

        var cmsURL = editor_config.path_absolute + route_prefix + '?editor=' + field_name;
        if (type == 'image') {
          cmsURL = cmsURL + "&type=Images";
        } else {
          cmsURL = cmsURL + "&type=Files";
        }

        tinyMCE.activeEditor.windowManager.open({
          file : cmsURL,
          title : 'Filemanager',
          width : x * 0.8,
          height : y * 0.8,
          resizable : "yes",
          close_previous : "no"
        });
      }
    };

    tinymce.init(editor_confihg);

    $('#lfm').filemanager('image', {prefix: route_prefix});

    var lfm = function(id, type, options) {
      let button = document.getElementById(id);
    
      button.addEventListener('click', function () {
        var route_prefix = (options && options.prefix) ? options.prefix : '/filemanager';
        var target_input = document.getElementById(button.getAttribute('data-input'));
        var target_preview = document.getElementById(button.getAttribute('data-preview'));
    
        window.open(route_prefix + '?type=' + options.type || 'file', 'FileManager', 'width=900,height=600');

        window.SetUrl = function (items) {
          var file_path = items.map(function (item) {
            return item;
          }).join(',');

          console.log(file_path);
          // set the value of the desired input to image url
          target_input.value = file_path;
          target_input.dispatchEvent(new Event('change'));
    
          // clear previous preview
          target_preview.innerHtml = '';
          // set or change the preview image src
          items.forEach(function (item) {
            let img = document.createElement('img')
            img.setAttribute('style', 'height: 5rem')
            img.setAttribute('src', item.thumb_url)
            target_preview.appendChild(img);
          });
    
          // trigger change event
          target_preview.dispatchEvent(new Event('change'));        
        };
      });
    };
// lfm('lfm', 'image', {prefix: route_prefix,  multiple: true});
$(document).ready(function () {
  $('#lfm').filemanager('image', {prefix: route_prefix});
});


