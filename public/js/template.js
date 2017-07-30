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

function getPath(path) {
    return basepath + path;
}

function viewPath(path)
{
    return basepath + 'Application/View/'+path+".mustache";
}