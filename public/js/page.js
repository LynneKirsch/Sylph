function savePage(autosave) {
    var form = $("#page_main_form").serializeObject();
    form.html = quill.root.innerHTML;
    form.delta = quill.getContents();
    $.post(getPath("admin/page/save/") + form.page_id, {form: JSON.stringify(form)}, function (response) {
        $("#saved_ts").html("Saved at " + response.time);
        if (!autosave) {
            $("#saved_autosave").html("");
        }
    });

    $("#page_demo_content").html(form.html);
}