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

function searchProperty()
{
    var beds_num = $("input[name=beds]:checked").val();
   $.post(basepath+"properties/search", {beds: beds_num}, function(response){
       console.log(response.html);
      $("#properties_wrap").html(response.html);
   });
}