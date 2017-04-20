<div class="container">
	<div id="login-box">
		<div class="logo">
			<button style="padding: 5px; background: none; box-shadow: none;border: none" onclick="window.history.back();">Quay lại trang trước</button>
			<img class="img img-responsive img-circle center-block" src="<?=data_url?>img/logo.png" alt="" style="width: 240px;"/>
			<h3 class="logo-caption"><span class="tweak"></span>Bạn vui lòng liên hệ đến ban quản trị để lấy mã QR để vào được trang này</h1>
		</div><!-- /.logo -->
		<div class="controls">
			<form action="lock/submit" method="POST">
				<input type="text" name="lock" placeholder="Mã QR" class="form-control" />
				<button type="submit" class="btn btn-default btn-block btn-custom">Lock</button>
			</form>
			<?php 
				session_start();
				if (isset($_SESSION["lock_faile"]))
				{ ?>

				<p class="text-warning">Thông báo: Mã QR không đúng!</p>

			<?php	}
			?>
		</div><!-- /.controls -->

	</div><!-- /#login-box -->
</div><!-- /.container -->
<div id="particles-js"></div>
<script type="text/javascript">
	$.getScript("https://cdnjs.cloudflare.com/ajax/libs/particles.js/2.0.0/particles.min.js", function(){
    particlesJS('particles-js',
      {
        "particles": {
          "number": {
            "value": 80,
            "density": {
              "enable": true,
              "value_area": 800
            }
          },
          "color": {
            "value": "#ffffff"
          },
          "shape": {
            "type": "circle",
            "stroke": {
              "width": 0,
              "color": "#000000"
            },
            "polygon": {
              "nb_sides": 5
            },
            "image": {
              "width": 100,
              "height": 100
            }
          },
          "opacity": {
            "value": 0.5,
            "random": false,
            "anim": {
              "enable": false,
              "speed": 1,
              "opacity_min": 0.1,
              "sync": false
            }
          },
          "size": {
            "value": 5,
            "random": true,
            "anim": {
              "enable": false,
              "speed": 40,
              "size_min": 0.1,
              "sync": false
            }
          },
          "line_linked": {
            "enable": true,
            "distance": 150,
            "color": "#ffffff",
            "opacity": 0.4,
            "width": 1
          },
          "move": {
            "enable": true,
            "speed": 6,
            "direction": "none",
            "random": false,
            "straight": false,
            "out_mode": "out",
            "attract": {
              "enable": false,
              "rotateX": 600,
              "rotateY": 1200
            }
          }
        },
        "interactivity": {
          "detect_on": "canvas",
          "events": {
            "onhover": {
              "enable": true,
              "mode": "repulse"
            },
            "onclick": {
              "enable": true,
              "mode": "push"
            },
            "resize": true
          },
          "modes": {
            "grab": {
              "distance": 400,
              "line_linked": {
                "opacity": 1
              }
            },
            "bubble": {
              "distance": 400,
              "size": 40,
              "duration": 2,
              "opacity": 8,
              "speed": 3
            },
            "repulse": {
              "distance": 200
            },
            "push": {
              "particles_nb": 4
            },
            "remove": {
              "particles_nb": 2
            }
          }
        },
        "retina_detect": true,
        "config_demo": {
          "hide_card": false,
          "background_color": "#b61924",
          "background_image": "",
          "background_position": "50% 50%",
          "background_repeat": "no-repeat",
          "background_size": "cover"
        }
      }
    );

});
</script>
<div class="col-lg-9 col-sm-8 right_content" style="margin-top: 16px;">
    <div class="row">
        <div class="product-container">
        	<div class="col-md-6 col-md-push-3">
        		<div class="form_lock">
        			<h3 class="text-center"></h3>
        		</div>
        	</div>
        </div>
    </div>
</div>