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

    var page_id = $("#page_id").val();
    $("#modal_page_"+page_id).modal('open');
});

function getPath(path) {
    return basepath + path;
}

function viewPath(path)
{
    return basepath + 'Application/View/'+path+".mustache";
}