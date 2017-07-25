$(document).ready(function () {
    $('.camera_wrap').camera({
        height: '25%',
        minHeight: "100px",
        pagination: false,
        thumbnails: false,
        loader: 'bar',
        alignment: 'center',
        fx: 'simpleFade',
        time: 3e3,
        transPeriod: 3000
    });

    tinymce.init({
        selector: 'textarea',
        height: 500,
        menubar: false,
        plugins: [
            'advlist autolink lists link image charmap print preview anchor',
            'searchreplace visualblocks code fullscreen',
            'insertdatetime media table contextmenu paste code'
        ],
        toolbar: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
        content_css: [
            '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
            '//www.tinymce.com/css/codepen.min.css']
    });
});

function savePage()
{
    var form = $("#page_main_form");
    var data =  $(form).serialize();
    data = data + "&content=" + tinymce.activeEditor.getContent({format: 'raw'});

    $.post($(form).attr("action"), data, function(response){
        console.log(response);
        $("#saved_ts").html("Saved at " + response.time);
    });

}

function searchProperty()
{
    var beds_num = $("input[name=beds]:checked").val();
   $.post(basepath+"properties/search", {beds: beds_num}, function(response){
       console.log(response.html);
      $("#properties_wrap").html(response.html);
   });
}