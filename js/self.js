$(function(){
    if(typeof $.fn.layerSlider == "undefined") { lsShowNotice("layerslider_1","jquery"); } 
    else { 
        $("#layerslider_1").layerSlider({
            responsive: true, 
            responsiveUnder: 1280, 
            layersContainer: 1280, 
            startInViewport: false,
            pauseOnHover: false, 
            forceLoopNum: false, 
            autoPlayVideos: false, 
            skinsPath: "/file/self/",
            skin: "fullwidthdark"
        })
    }
    new WOW().init();
    $( "#tabs" ).tabs();
    $("body").append('<a href="#" class="scrollTo-top" style="display: inline;"><i class="fa fa-angle-double-up"></i></a>');
    var viewPortWidth = $(window).width();
    $(window).scroll(function(event) {
        event.preventDefault();
        if ($(this).scrollTop() > 180) {
            $('.scrollTo-top').fadeIn();
        } else {
            $('.scrollTo-top').fadeOut();
        }
    });    
    $('.scrollTo-top').click(function(event) {
        $('html, body').animate({scrollTop : 0 }, 600);
        event.preventDefault();
    }); 
    
    $("#search #hint").keyup(function(e){
        if(e.keyCode==13){
            var val=$(this).val();
            if(val==''){
                alert('Bạn chưa nhập từ khoá...');
                return;
            }else{            
                var val=val.split(' ');
                var val=val.join('-');
                $( location ).attr("href","/tim-kiem/"+val);
            }     
        }
    })
    
    $(".test-popup-link").magnificPopup({
      type: "image",
      zoom: {
        enabled: true,
        duration: 300
      }
    });
    $('.popup-gallery').magnificPopup({
        delegate: 'a',
        type: 'image',
        tLoading: 'Loading image #%curr%...',
        mainClass: 'mfp-img-mobile',
        gallery: {
            enabled: true,
            navigateByImgClick: true,
            preload: [0,1] // Will preload 0 - before current, and 1 after the current image
        },
        zoom: {
            enabled: true,
            duration: 300
        },
        image: {
            verticalFit:true
        }
	});   
    $('.popup-youtube, .popup-vimeo, .popup-gmaps').magnificPopup({
      disableOn: 700,
      type: 'iframe',
      mainClass: 'mfp-fade',
      removalDelay: 160,
      preloader: false,
      zoom: {
            enabled: true,
            duration: 300
      },
      fixedContentPos: false
    });  
})
/*$(function(){
    new WOW().init();
    if(typeof $.fn.layerSlider == "undefined") { lsShowNotice("layerslider_1","jquery"); } 
    else { 
        $("#layerslider_1").layerSlider({
            responsiveUnder: 1600,    
            layersContainer: 1300, 
            pauseOnHover: false, 
            forceLoopNum: false, 
            autoPlayVideos: false, 
            skinsPath: "/file/self/",
            skin: "fullwidthdark"
        })
    } 
    $( "#tabs" ).tabs();
       
    $("#search").on('submit',function(e){
        e.preventDefault();
        var val=$(this).find("#hint").val();
        var val=val.split(' ');
        var val=val.join('-');
        $( location ).attr("href","/tim-kiem/"+val);
    });*/
    
    /*$("body").append('<a href="#" class="scrollTo-top" style="display: inline;"><i class="fa fa-angle-double-up"></i></a>');
    var viewPortWidth = $(window).width();
    $(window).scroll(function(event) {
        event.preventDefault();
        if ($(this).scrollTop() > 180) {
            $('.scrollTo-top').fadeIn();
        } else {
            $('.scrollTo-top').fadeOut();
        }
    });    
    $('.scrollTo-top').click(function(event) {
        $('html, body').animate({scrollTop : 0 }, 600);
        event.preventDefault();
    }); 
    $(".test-popup-link").magnificPopup({
      type: "image",
      zoom: {
        enabled: true,
        duration: 300
      }
    });
    $('.popup-gallery').magnificPopup({
        delegate: 'a',
        type: 'image',
        tLoading: 'Loading image #%curr%...',
        mainClass: 'mfp-img-mobile',
        gallery: {
            enabled: true,
            navigateByImgClick: true,
            preload: [0,1] // Will preload 0 - before current, and 1 after the current image
        },
        zoom: {
            enabled: true,
            duration: 300
        },
        image: {
            verticalFit:true
        }
	});   
    $('.popup-youtube, .popup-vimeo, .popup-gmaps').magnificPopup({
      disableOn: 700,
      type: 'iframe',
      mainClass: 'mfp-fade',
      removalDelay: 160,
      preloader: false,
      zoom: {
            enabled: true,
            duration: 300
      },
      fixedContentPos: false
    });  
    $("#search button").on('click',function(e){
        var val=$('#search').find("#hint").val();
        if(val==''){
            alert('Bạn chưa nhập từ khoá...');
            return;
        }else{            
            var val=val.split(' ');
            var val=val.join('-');
            $( location ).attr("href","/tim-kiem/"+val);
        }   
    })
    //Start slick
    $('.responsive').slick({
      dots: true,
      infinite: true,
      speed: 300,
      slidesToShow: 4,
      slidesToScroll: 4,
      responsive: [
        {
          breakpoint: 1024,
          settings: {
            slidesToShow: 3,
            slidesToScroll: 3,
            infinite: true,
            dots: true
          }
        },
        {
          breakpoint: 600,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 2
          }
        },
        {
          breakpoint: 480,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1
          }
        }
        // You can unslick at a given breakpoint now by adding:
        // settings: "unslick"
        // instead of a settings object
      ]
    });
    //End slick
})*/


