<?php echo form_open(site_url('ajax/login'),'class="form-signin m-login__form"');?>
  <img class="mb-4" src="/templates/admin_themes/users/img/icon.png" alt="" width="72" height="72">
  <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
  <label for="inputEmail" class="sr-only">Email address</label>
  <input type="email" id="inputEmail" class="form-control" name="identity" placeholder="Email address" required autofocus>
  <label for="inputPassword" class="sr-only">Password</label>
  <input type="password" id="inputPassword" class="form-control" placeholder="Password" name="password" required>
  <div class="checkbox mb-3">
    <label>
      <input type="checkbox" value="remember-me"> Remember me
    </label>
  </div>
  <button class="btn btn-lg btn-primary btn-block" type="submit" id="m_login_signin_submit">Sign in</button>
  <p class="mt-5 mb-3 text-muted">&copy; 2017-2020</p>
<?php echo form_close();?>

<script type="text/javascript">
  function isJson(str) 
  {
      try {
          JSON.parse(str);
      } catch (e) {
          return false;
      }
      return true;
  }

  function encryptdata(pass,data)
  {
      if(data){
          item = {};
          $(data).each(function(i,element){
              name = element.name;
              value = (CryptoJS.AES.encrypt(JSON.stringify(element.value),passphrase, {format: CryptoJSAesJson}).toString());
              item[name] = value;
          });
          return (item);
      }
  }

  var isMobile = false;
  if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|ipad|iris|kindle|Android|Silk|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(navigator.userAgent) || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(navigator.userAgent.substr(0,4))) { 
    isMobile = true;
  }

  var SnippetLogin = function () 
  {
    $("#m_login");
    var t = function () 
    {
      $("#m_login_signin_submit").click(function (t) 
      {
        t.preventDefault();
        var e = $(this),
          a = $(".m-login__form");
        var s = $('.second_button');
        a.find(".alert").html('').slideUp();
        a.validate({
          rules: {
            identity: {
                required: true
            },
            password: {
                required: true
            }
          },
          messages: {
            identity: {
              required: "Hey, ensure this field is not empty"
            },
            password: {
              required: "Enter password to continue",
            }
          }
        }),a.valid() && (e.addClass("m-loader m-loader--right m-loader--light").attr("disabled", !0),
        s.addClass('disabled'),
        $.post({
          url: "<?php echo site_url('ajax/login');?>",
          data : encryptdata(passphrase,a.serializeArray()),
          success: function (t, i, n, r) 
          {
            if(isJson(t)){
              response = $.parseJSON(t);
              if(response.status == '1'){
                window.location.href = response.refer;
              }else if(response.status == '200'){
                //Toastr.show("Session Active",response.message,'info');
                window.location.href = response.refer;
              }else{
                var message = '';
                if(response.hasOwnProperty('refer')){
                  //Toastr.show("Login Error",response.message,'error');
                  window.location.href = response.refer;
                }else if(response.hasOwnProperty('validation_errors')){
                  validation_errors = response.validation_errors;
                  $.each(validation_errors, function( key, value ) 
                  {
                    message+= value+"<br/>";
                  });
                }else{
                  message = response.message;
                }
                setTimeout(function () 
                {
                  e.removeClass("m-loader m-loader--right m-loader--light").attr("disabled", !1),s.removeClass('disabled'),
                    function (t, e, a) 
                    {
                      var i = $('<div class="m-alert--air mb-5 m-alert alert alert-' + e + ' alert-dismissible" role="alert">\t\t\t<button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>\t\t\t<span></span>\t\t</div>');
                      t.find(".alert").remove(), i.prependTo(t), i.find("span").html(a)
                    }(a, "danger",message)
                }, 2e3)
              }
            }else{
              setTimeout(function () 
              {
                e.removeClass("m-loader m-loader--right m-loader--light").attr("disabled", !1),s.removeClass('disabled'),
                  function (t, e, a) 
                  {
                    var i = $('<div class="m-alert--air mb-5 m-alert alert alert-' + e + ' alert-dismissible" role="alert">\t\t\t<button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>\t\t\t<span></span>\t\t</div>');
                    t.find(".alert").remove(), i.prependTo(t), i.find("span").html(a)
                  }(a, "danger", "Could not complete processing the request at the moment.")
              }, 2e3)
            }
          },
          error: function()
          {
            setTimeout(function () 
            {
              e.removeClass("m-loader m-loader--right m-loader--light").attr("disabled", !1),s.removeClass('disabled'),
                function (t, e, a) 
                {
                  var i = $('<div class="m-alert--air mb-5 m-alert alert alert-' + e + ' alert-dismissible" role="alert">\t\t\t<button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>\t\t\t<span></span>\t\t</div>');
                  t.find(".alert").remove(), i.prependTo(t),i.find("span").html(a)
                }(a, "danger", "Could not complete processing the request at the moment.")
            }, 2e3)
          },
          always: function()
          {
            setTimeout(function () 
            {
              e.removeClass("m-loader m-loader--right m-loader--light").attr("disabled", !1),s.removeClass('disabled'),
                function (t, e, a) 
                {
                  var i = $('<div class="m-alert--air mb-5 m-alert alert alert-' + e + ' alert-dismissible" role="alert">\t\t\t<button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>\t\t\t<span></span>\t\t</div>');
                  t.find(".alert").remove(), i.prependTo(t),i.find("span").html(a)
                }(a, "danger", "Could not complete processing the request at the moment.")
            }, 2e3)
          }
        }))
      })
    };
    return {
      init: function () 
      {
        t()
      }
    }
  }();
  jQuery(document).ready(function () 
  {
    if(isMobile){
      $('.toggle_password_visibility').hide();
    }
    $('.toggle_password_visibility').on('click', function() {
      $(this).toggleClass('fa-eye-slash').toggleClass('fa-eye');
      $('.cust_login_password').togglePassword().focus();
    });
    SnippetLogin.init();

    $(".prlx_shell").mousemove(function(e){
      $('.prlx.img_group').css({'margin-left': prx_getNewY(e, -1, -5) + 'px'});
      $('.prlx.img_admin').css({'margin-left': (240 + prx_getNewY(e, 0.5, +5)) + 'px'});
      $('.prlx.img_entry').css({'margin-left': (300 + prx_getNewY(e, -2, -5)) + 'px'});
    });

  });
</script>