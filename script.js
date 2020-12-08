$.ajaxSetup({
  url: 'handler.php',
  type: 'POST',
  dataType: 'json',
  beforeSend: function(){
    console.log("send query");
  },
  error: function(req, text, error){
    console.log('Хьюстон, У нас проблемы! ' + text + ' | ' + error);
  },
  complete: function(){
    console.log("query complete");
  }
});




$(function(){
  $('#auth_form').on('submit', function(e){
    e.preventDefault();
    var $that = $(this),
        fData = $that.serialize(); // сериализируем данные
        // ИЛИ
        // fData = $that.serializeArray();
    $.ajax({
      data: {auth_data: fData},
      success: function(json){
        // В случае успешного завершения запроса...
        if(json){
          //console.log($('#reg'));
          $('#reg').css('display', 'none');
          $that.replaceWith(json); // заменим форму данными, полученными в ответе.
        }
      }
    });
  });
});

$(function(){
  $('#reg_form').on('submit', function(e){
    e.preventDefault();
    var $that = $(this),
        fData = $that.serialize(); // сериализируем данные
        // ИЛИ
        // fData = $that.serializeArray();
    $.ajax({
      url: $that.attr('action'), // путь к обработчику берем из атрибута action
      type: $that.attr('method'), // метод передачи - берем из атрибута method
      data: {reg_data: fData},
      dataType: 'json',
      success: function(json){
        // В случае успешного завершения запроса...
        if(json){
          $that.replaceWith(json); // заменим форму данными, полученными в ответе.
        }
      }
    });
  });
});

$(function(){///////////////////////
  /*$('#add_form').on('submit', function(e){*/
  $('body').on('submit', '#add_form', function(e) {
    e.preventDefault();
    //alert("fs");
    var $that = $(this),
        fData = $that.serialize(); // сериализируем данные
        // ИЛИ
        // fData = $that.serializeArray();
        var elem = $(".catalog");

        catalog = elem.data('catalog');

           var data_for = new FormData();

//Form data
var form_data = $('#add_form').serializeArray();
$.each(form_data, function (key, input) {
    data_for.append(input.name, input.value);
});

//File data
var file_data = $('input[name="photo"]')[0].files;
for (var i = 0; i < file_data.length; i++) {
    data_for.append("my_images[]", file_data[i]);
    console.log(file_data[i]);
}

/*$.ajax({
    url: 'catalog.php?SECTION=' + catalog,
    method: "post",
    processData: false,
    contentType: false,
    data: {add_data: data},
    success: function (data) {
        if(data){
          $that.replaceWith(data); // заменим форму данными, полученными в ответе.
          //location.reload();
        }
    },
    error: function (e) {
        //error
    }
});

*/
    $.ajax({
      url: 'catalog.php?SECTION=' + catalog, // путь к обработчику берем из атрибута action
      type: 'POST', // метод передачи - берем из атрибута method
      data: {add_data: fData},
      dataType: 'json',
      success: function(json){
        // В случае успешного завершения запроса...
        if(json){
          $that.replaceWith(json); // заменим форму данными, полученными в ответе.
          //location.reload();
        }
      }
    });
  });
});

$(function(){///////////////////////
  /*$('#update_form').on('submit', function(e){*/
  $('body').on('submit', '#update_form', function(e) {
    e.preventDefault();
    let id = $(e.currentTarget).parent().data('id');
    var $that = $(this),
        fData = $that.serialize(); // сериализируем данные
        // ИЛИ
        // fData = $that.serializeArray();
    $.ajax({
      url: 'catalog.php?SECTION=' + catalog + '&ID=' + id, // путь к обработчику берем из атрибута action
      type: 'POST', // метод передачи - берем из атрибута method
      data: {update_data: fData},
      dataType: 'json',
      success: function(json){
        // В случае успешного завершения запроса...
        if(json){
          $that.replaceWith(json); // заменим форму данными, полученными в ответе.
          location.reload();
        }
      }
    });
  });
});



function query(){
    var elem = $(".catalog");

    catalog = elem.data('catalog');
    console.log(catalog);


      $.ajax({
        url: 'catalog.php?SECTION=' + catalog, // путь к php-обработчику
          success: function(data){ // функция, которая будет вызвана в случае удачного завершения запроса к серверу
            // json - переменная, содержащая данные ответа от сервера. Обзывайте её как угодно ;)
            elem.html(data);// выводим на страницу данные, полученные с сервера
            //console.log(data);
            
          //item.classList.toggle("spinner");
          
        }
      });
 
  };


  $(document).ready(function(){
    query();
  });


  $(function() {
      $(document).on("click", ".enter", function(e) {
        e.preventDefault();
        $(".modal_background").css({"display":"flex"});
        $(".modal_form").fadeIn();

        $('#register').css('display', 'none');
        $('#auth').css('display', 'flex');
      });

      $(document).on("click", ".exit", function(e) {
        e.preventDefault();
        $.ajax({
          url: 'handler.php?EXIT=1',
          success: function(data){
            $('.exit').toggleClass('exit').toggleClass('enter');
            location.reload();
          }

        });
      });

/*---------------queries-------------------*/
    $(document).on("click", "#add_product", function(e) {
        e.preventDefault();

        let catalog = $('.catalog').data('catalog');
        //console.log(catalog);

        let elem = $(".adminPanel").children(".modal_background.add").get(0);
        $(elem).css({"display":"flex"});
        $(".modal_form").fadeIn();

        $.ajax({
          url: 'catalog.php?MANIPULATE=1&SECTION=' + catalog,
          success: function(data){
            $($(elem).find("form").get(0)).html(data);
            $($(elem).find("form").get(0)).attr('id', 'add_form');
          }

        });
      });

    $(document).on("click", "#add_breed", function(e) {
        e.preventDefault();

        let catalog = $('.catalog').data('catalog');
        //console.log(catalog);

        let elem = $(".adminPanel").children(".modal_background.add").get(0);
        $(elem).css({"display":"flex"});
        $(".modal_form").fadeIn();

        $.ajax({
          url: 'catalog.php?MANIPULATE=4&TYPE=breeds',
          success: function(data){
            $($(elem).find("form").get(0)).html(data);
            $($(elem).find("form").get(0)).attr('id', 'add_breed_form');
          }

        });
      });

    $(document).on("click", "#add_pet", function(e) {
        e.preventDefault();

        let catalog = $('.catalog').data('catalog');
        //console.log(catalog);

        let elem = $(".adminPanel").children(".modal_background.add").get(0);
        $(elem).css({"display":"flex"});
        $(".modal_form").fadeIn();

        $.ajax({
          url: 'catalog.php?MANIPULATE=4&TYPE=petsnames',
          success: function(data){
            $($(elem).find("form").get(0)).html(data);
            $($(elem).find("form").get(0)).attr('id', 'add_pet_form');
          }

        });
      });

    $(document).on("click", "#add_nutrition_name", function(e) {
        e.preventDefault();

        let catalog = $('.catalog').data('catalog');
        //console.log(catalog);

        let elem = $(".adminPanel").children(".modal_background.add").get(0);
        $(elem).css({"display":"flex"});
        $(".modal_form").fadeIn();

        $.ajax({
          url: 'catalog.php?MANIPULATE=4&TYPE=nutritiontypes',
          success: function(data){
            $($(elem).find("form").get(0)).html(data);
            $($(elem).find("form").get(0)).attr('id', 'add_nutrition_name_form');
          }

        });
      });



    

      $(document).on("click", ".updateBut", function(e) {
        e.preventDefault();

        let catalog = $('.catalog').data('catalog');
        let id = $(e.currentTarget).parent().data('id');
        //console.log(catalog);
        let elem = $(".adminPanel").children(".modal_background.add").get(0);
        $(elem).css({"display":"flex"});
        $(".modal_form").fadeIn();

        $.ajax({
          url: 'catalog.php?MANIPULATE=3&SECTION=' + catalog + '&ID=' + id,
          success: function(data){
            //console.log($(elem).find("form").get(0));
            $($(elem).find("form").get(0)).html(data);
            $($(elem).find("form").get(0)).attr('id', 'update_form');
            //alert(data);
            /*$('.exit').toggleClass('exit').toggleClass('enter');
            location.reload();*/
          }

        });
      });

      
      $(document).on("click", ".delete", function(e) {
        e.preventDefault();

        let catalog = $('.catalog').data('catalog');
        let id = $(e.currentTarget).parent().data('id');
        //console.log(id);
        var deleteOK = confirm("Вы действительно хотите удалить этот товар?");
        if (deleteOK) {
          $.ajax({
            url: 'catalog.php?MANIPULATE=2&SECTION=' + catalog + '&ID=' + id,
            success: function(data){
              alert(data);
              //$('.exit').toggleClass('exit').toggleClass('enter');
              location.reload();
            }

          });

        }else{
          alert("Товар не удален");
        }


      });

/*----------------------------------------*/
      $(document).on("click", ".buy", function(e) {
        e.preventDefault();

        let catalog = $('.catalog').data('catalog');
        let id = $(e.currentTarget).parent().data('id');
        console.log(catalog + " " + id);
/*
        let elem = $(".adminPanel").children(".modal_background.add").get(0);
        $(elem).css({"display":"flex"});
        $(".modal_form").fadeIn();*/

        $.ajax({
          url: 'catalog.php?BUY=1&SECTION=' + catalog + "&ID=" + id,
          success: function(data){
            alert(data);
            location.reload();

            /*$($(elem).find("form").get(0)).html(data);
            $($(elem).find("form").get(0)).attr('id', 'add_form');*/
          }

        });
      });



      $(document).on("click", ".close_form", function(e) {
          e.preventDefault();
          let elem = $(e.currentTarget);
          $($(elem).parents(".modal_background").get(0)).hide();
          $($(elem).parents(".modal_form").get(0)).css({"display":"none"});
          //console.log(elem.parents(".modal_background").get(0));
      });

      $(document).on("click", ".reg", function(e) {
        e.preventDefault();
        $('#register').css('display', 'flex');
        $('#auth').css('display', 'none');
        $('#reg').css('display', 'none');
      });

      $(document).on("click", ".nav", function(e) {
        e.preventDefault();
        var catalogId = $(e.currentTarget).data('id');
        var catalogId2 = catalogId;
        switch (catalogId){
          case 1:
            catalogId = 'pets';
            break;
          case 2:
            catalogId = 'nutrition';
            break;
          case 3:
            catalogId = 'toys';
            break;
          default:
            catalogId = 'pets';
            break;

        }

          elem = $(".catalog").get(0);
          //console.log(elem);

      $(elem).data("catalog", catalogId).attr('data-catalog', catalogId);
      query();
      elem = $('nav').get(0);

      var plagBut = $(elem).find(".nav");
      //console.log($(plagBut).get(0));
      //console.log(catalogId);


      for (const plag of plagBut){
        if ($(plag).data('id') == catalogId2) {
          //console.log(plag);
          plag.classList.add("active");
        }else if(plag.classList.contains("active")){
          plag.classList.remove("active");
        }
      }
//      $(elem).toggleClass('active');
      

      });
  });     

