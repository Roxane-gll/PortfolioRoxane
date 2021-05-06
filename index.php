<?php include_once('home.html');

$access_token=getenv('accessToken');


?>
<?php
?>

<script type="text/javascript">

let aProposPerson=document.getElementById('aPropos')
let contactsPerson=document.getElementById('contact')

//add info from dribbble

$.ajax({
    url: 'https://api.dribbble.com/v2/user?access_token='+/*'<?= getenv('accessToken') ?>'*/'e439a6dc4d286ebee41d358acbc7fba1f69ad625e4db3854d6016724a5503638',
    dataType: 'json',
    type: 'GET',
    success: function(data) {
        let links=Object.entries(data.links)
        $('#footer').append(
            `<a href="${data.html_url}">Plus de projet sur dribbble</a>`
        )
        var keys = [];
        for (var key in links) {
            if (links.hasOwnProperty(key)) {
                $('#contact').append(
                    `<li><a href="${links[key][1]}"><img src=image/icones/${links[key][0]}.svg id='${links[key][0]}'></a></li>`
                )
                $('#footer').append(
                    `<li><a href="${links[key][1]}"><img src=image/icones/${links[key][0]}_clair.svg></a></li>`
                )
            }
        }

        let bio=data.bio.replaceAll('\n', '</p><p>')
        aProposPerson.innerHTML=`
        <img id='aProposPhrase' src="image/aPropos/titre.svg"/>
        <div><p>${bio}</p></div>`

    }
})

//add projet

$.ajax({
    url: 'https://api.dribbble.com/v2/user/shots?access_token='+/*'<?= getenv('accessToken') ?>'*/'e439a6dc4d286ebee41d358acbc7fba1f69ad625e4db3854d6016724a5503638'+'&per_page=100',
    dataType: 'json',
    type: 'GET',
    success: function(data) {
        if (data.length > 0) {
            $.each(data.reverse(), function(i, val) {
                let title=val.title.slice(0,-3).toLowerCase().replaceAll(' ', '_').replaceAll('?', '').replaceAll('"','').replaceAll("'",'')
                let inData
                if(val.description!==null){
                    inData='<a class="shot" target="_blank" href="'+ val.html_url +'" title="' + val.title.slice(0,-3) + '"><span class="fleche"></span><div class="title">' + val.title.slice(0,-3) + '</div><img src="'+ val.images.hidpi +'"/><p>'+val.description+'</p></a>'
                }else{
                    inData='<a class="shot" target="_blank" href="'+ val.html_url +'" title="' + val.title.slice(0,-3) + '"><span class="fleche"></span><div class="title">' + val.title.slice(0,-3) + '</div><img src="'+ val.images.hidpi +'"/></a>'
                }
                
                if(val.title.includes('#1')){
                    $('#projets').prepend(
                        '<div id="'+title+'" class="carousel slide" data-ride="carousel">\n' +
                        '<ol class="carousel-indicators" id="'+title+'-indicators">\n' +
                        '    <li data-target="#carouselExampleIndicators" data-slide-to="1" class="active"></li>\n' +
                        '</ol>\n'+
                        '<div class="carousel-inner" id="'+title+'-inner">\n'+
                        '   <div class="carousel-item active">\n' +
                        inData +
                        '   </div>\n'+

                        '</div>\n'+
                        '<a class="carousel-control-prev" href="#'+title+'" role="button" data-slide="prev">\n' +
                    '       <span class="carousel-control-prev-icon" aria-hidden="true"></span>\n' +
                    '       <span class="sr-only">Previous</span>\n' +
                    '   </a>\n' +
                    '   <a class="carousel-control-next" href="#'+title+'" role="button" data-slide="next">\n' +
                    '       <span class="carousel-control-next-icon" aria-hidden="true"></span>\n' +
                    '       <span class="sr-only">Next</span>\n' +
                    '   </a>\n'
                        
                    )
                    if ($('#project').children.length===6){
                        $('#project').removeChild(list.childNodes[4]);
                    }
                }else{
                    $('#'+title+'-inner').append(
                        '<div class="carousel-item">\n' +
                        inData +
                        '   </div>'
                    )
                    $('#'+title+'-indicators').append('<li data-target="#carouselExampleIndicators" data-slide-to="'+val.title.slice(-1)+'"></li>')
                }
            })
        }
        else {
            $('#projets').append(
                '<div id="no-shots" class="carousel slide" data-ride="carousel">\n' +
                '<div class="carousel-inner">\n'+
                '   <div class="carousel-item active">\n' +
                '        <p class="car">no shots</p>\n' +
                '   </div>\n'+
                '<a class="carousel-control-prev" href="#no-shots" role="button" data-slide="prev">\n' +
                '       <span class="carousel-control-prev-icon" aria-hidden="true"><</span>\n' +
                '       <span class="sr-only">Previous</span>\n' +
                '   </a>\n' +
                '   <a class="carousel-control-next" href="#no-shots" role="button" data-slide="next">\n' +
                '       <span class="carousel-control-next-icon" aria-hidden="true"> > </span>\n' +
                '       <span class="sr-only">Next</span>\n' +
                '   </a>\n' +
                '</div>\n'
            );
        }
    }
});

</script>
<script type="module" src="portfolio.js"></script>
