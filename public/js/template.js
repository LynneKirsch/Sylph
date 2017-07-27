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
});

function savePage(autosave)
{
    var form = $("#page_main_form").serializeObject();
    form.html = quill.root.innerHTML;
    form.delta = quill.getContents();
    $.post(basepath + "admin/page/save/"+form.page_id, {form: JSON.stringify(form)}, function(response){
        $("#saved_ts").html("Saved at " + response.time);
        if(!autosave) {
            $("#saved_autosave").html("");
        }
    });

    $("#page_demo_content").html(form.html);
}