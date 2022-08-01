  <!-- jquery -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <!-- slick -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js" integrity="sha512-XtmMtDEcNz2j7ekrtHvOVR4iwwaD6o/FUJe6+Zq+HgcCsk3kj4uSQQR8weQ2QVj1o0Pk6PwYLohm206ZzNfubg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

  <!-- Bootsrap 5 script CDN -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>

  <!-- Script File CDN -->
  <script src="./assets/js/main.js"></script>
  <!-- Alertify -->
  <script type="text/javascript" src="./assets/js/alertify.min.js"></script>

  <script>

  const renderFunction = function() {
    const html = `<div class="loader_div">
    <img src="./assets/icons&images/mybit/download.svg" alt="">
  </div>`;

  document.body.insertAdjacentHTML('beforebegin', html);
  }

  renderFunction();

    const loaderElm = document.querySelector('.loader_div');

    window.onload = function() {
        const timer = setInterval(() => {
          loaderElm.style.display = 'none';
          clearInterval(timer)
        }, 2000);
      }
  </script>

  <?php echo toast(1); ?>