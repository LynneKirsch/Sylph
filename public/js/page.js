function savePage(autosave) {
    var form = $("#page_main_form").serializeObject();
    form.html = quill.root.innerHTML;
    form.delta = quill.getContents();
    $.post(getPath("admin/page/save/") + form.page_id, {form: JSON.stringify(form)}, function (response) {
        if (!autosave) {
            $("#saved_ts").html("Saved at " + response.time);
        } else {
            $("#saved_ts").html("Autosaved at " + response.time);
        }
    });

    $("#page_demo_content").html(form.html);
}

function deletePage(id)
{
    $.post(getPath("admin/page/delete/") + id, null, function () {
        $(".row.page_" + id).remove();
    });
}

function removeSlide(el)
{
    $(el).closest(".slide_row").remove();
}

function newSlide()
{
    $.get(viewPath("partials/admin/slide_row"), function(template) {
        var tpl = Mustache.render(template, {});
        console.log(tpl);
        $("#slides_wrap").append(tpl);
    });

}