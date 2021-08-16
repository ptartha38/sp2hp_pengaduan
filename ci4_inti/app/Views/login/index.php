<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>SP2HP Online Pengaduan</title>
  <meta content="" name="description">

  <meta content="" name="keywords">
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/css/bootstrap-select.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/js/bootstrap-select.min.js"></script>
  <!-- Data Tables CSS -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.20/b-1.6.1/b-flash-1.6.1/b-html5-1.6.1/b-print-1.6.1/fc-3.3.0/r-2.2.3/datatables.min.css" />
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.20/b-1.6.1/b-flash-1.6.1/b-html5-1.6.1/b-print-1.6.1/fc-3.3.0/r-2.2.3/datatables.min.js"></script>

  <!-- Favicons -->
  <link href="<?= base_url() ?>/tema/assets/img/favicon.png" rel="icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="<?= base_url() ?>/tema/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?= base_url() ?>/tema/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="<?= base_url() ?>/tema/assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="<?= base_url() ?>/tema/assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="<?= base_url() ?>/tema/assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="<?= base_url() ?>/tema/assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="<?= base_url() ?>/tema/assets/css/style.css" rel="stylesheet">

</head>

<script>
  function formatDate(date) {
    var d = new Date(date),
      month = '' + (d.getMonth() + 1),
      day = '' + d.getDate(),
      year = d.getFullYear();

    if (month.length < 2)
      month = '0' + month;
    if (day.length < 2)
      day = '0' + day;

    return [day, month, year].join('-');
  }

  function nl2br(str, is_xhtml) {
    if (typeof str === 'undefined' || str === null) {
      return '';
    }
    var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />-' : '<br>-';
    return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
  }

  function proses() {
    $.ajax({
      url: "<?php echo base_url('login/cari_sp2hp'); ?>",
      type: 'POST',
      dataType: 'JSON',
      data: $('#form-cari').serialize(),
      success: function(x) {
        if (x.sukses == true) {
          var pelapor = x.data.nama_pelapor
          var nomor_hp = x.data.no_hp_plp
          var tanggal_surat = x.data.tanggal_surat
          var tanggal_terima = x.data.tanggal_terima
          var perkara = x.data.perkara
          if (x.data.tindak_lanjut != "") {
            tindak_lanjut = "- " + nl2br(x.data.tindak_lanjut)
          } else {
            tindak_lanjut = "Laporan pengaduan anda telah kami terima dan akan segera dilakukan penyelidikan."
          }
          var unit = x.data.ket
          Swal.fire({
            width: 800,
            title: '<strong>Data Ditemukan</strong>',
            icon: 'info',
            html: `<table id="detail" class="table table-bordered table-responsive" border=1 responsive>
        <thead>
            <tr>
                <th>Nama Pelapor</th>
                <th>No Handphone</th>
                <th>Tanggal Pengaduan</th>
                <th>Tanggal Diterima</th>
                <th>Dugaan Tindak Pidana</th>
            </tr>
        </thead>
        <tbody>
            <tr>
            ` + '<td>' + pelapor + '</td>' +
              '<td>' + nomor_hp + '</td>' +
              '<td>' + formatDate(tanggal_surat) + '</td>' +
              '<td>' + formatDate(tanggal_terima) + '</td>' +
              '<td>' + perkara + '</td>' +
              `</tr>
</tbody>
</table>` + `<table id="tindak_lanjut" class="table table-bordered table-responsive" border=1 responsive>
        <thead>
            <tr>
                <th>Tindak Lanjut</th>
            </tr>
        </thead>
        <tbody>
            <tr>
            ` + '<td align="left">' + tindak_lanjut + '</td>' +
              `</tr>
</tbody>
</table>` + `<table id="unit" class="table table-bordered" border=1>
        <thead>
        <tr>
                <th>Unit Yang Menangani</th>
            </tr>
        </thead>
        <tbody>
            <tr>
            ` + '<td>' + unit + '</td>' +
              `</tr> 
</tbody>
</table>`,
            showCloseButton: true,
            showCancelButton: false,
            focusConfirm: false,
            confirmButtonAriaLabel: 'Thumbs up, great!',
            cancelButtonText: '<i class="fa fa-thumbs-down"></i>',
            cancelButtonAriaLabel: 'Thumbs down'
          })
        } else {
          Swal.fire(
            'WARNING!',
            "DATA TIDAK DITEMUKAN , PASTIKAN ANDA MENGISI DATA DENGAN BENAR",
            'error'
          )
        }
      }
    });
  }
</script>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top">
    <div class="container-fluid container-xl d-flex align-items-center justify-content-between">

      <a href="#" class="logo d-flex align-items-center">
        <img src="<?= base_url() ?>/tema/assets/img/poldaNTB.png" alt="">
        <span> Polres Sumbawa</span>
      </a>

      <nav id="navbar" class="navbar">
        <ul>

          <li><a class="getstarted scrollto" href="#about">Cari SP2HP</a></li>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

    </div>
  </header><!-- End Header -->

  <!-- ======= Hero Section ======= -->
  <section id="hero" class="hero d-flex align-items-center">

    <div class="container">
      <div class="row">
        <div class="col-lg-6 d-flex flex-column justify-content-center">
          <h1 data-aos="fade-up">SP2HP Online Pengaduan</h1>
          <h2 data-aos="fade-up" data-aos-delay="400">SP2HP Online Pengaduan adalah Sistem yang dibuat oleh Polres Sumbawa khusus Fungsi Teknis Satreskrim agar memudahkan masyarakat dalam mengecek perkembangan laporan pengaduan.</h2>
          <div data-aos="fade-up" data-aos-delay="600">
            <div class="text-center text-lg-start">
              <a href="#about" class="btn-get-started scrollto d-inline-flex align-items-center justify-content-center align-self-center">
                <span>Cari SP2HP</span>
                <i class="bi bi-arrow-right"></i>
              </a>
            </div>
          </div>
        </div>
        <div class="col-lg-6 hero-img" data-aos="zoom-out" data-aos-delay="200">
          <img src="<?= base_url() ?>/tema/assets/img/logo_laptop.png" class="img-fluid" alt="">
        </div>
      </div>
    </div>

  </section><!-- End Hero -->

  <main id="main">
    <!-- ======= About Section ======= -->
    <section id="about" class="about">

      <div class="container" data-aos="fade-up">
        <div class="row gx-0">

          <div class="col-lg-6 d-flex flex-column justify-content-center" data-aos="fade-up" data-aos-delay="200">
            <div class="content">
              <h3>Isi Data Anda di Bawah Ini</h3>
              <form id="form-cari">
                <div class="input-group mb-3">
                  <span class="input-group-text" id="basic-addon1">Nama</span>
                  <input type="text" class="form-control" id="nama_pelapor" name="nama_pelapor" placeholder="Nama Pelapor" aria-label="Nama Pelapor" aria-describedby="basic-addon1" autocomplete="off" required>
                </div>
                <div class="input-group mb-3">
                  <span class="input-group-text" id="basic-addon1">No Handphone</span>
                  <input type="number" class="form-control" id="nomor_handphone" name="nomor_handphone" placeholder="Nomor Handphone" aria-label="Nama Pelapor" aria-describedby="basic-addon1" autocomplete="off" required>
                </div>
              </form>
              <div class="text-center text-lg-start">
                <button id="cari" name="cari" class="btn-read-more d-inline-flex align-items-center justify-content-center align-self-center" onclick="proses()">Cari Data <i class="bi bi-search"></i></button>
              </div>
            </div>
          </div>

          <div class="col-lg-6 d-flex align-items-center" data-aos="zoom-out" data-aos-delay="200">
            <img src="<?= base_url() ?>/tema/assets/img/search.png" class="img-fluid" alt="">
          </div>
        </div>
      </div>

    </section><!-- End About Section -->

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">

    <div class="footer-newsletter">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-12 text-center">
            <h4>Ingin Membuat Pengaduan Secara Online ?</h4>
            <a href="https://sumbawa.ntb.polri.go.id/pengaduan-masyarakat" class="btn btn-dark" role="button">Klik Disini</a>
          </div>
        </div>
      </div>
    </div>

    <div class=" footer-top">
      <div class="container">
        <div class="row gy-4">
          <div class="col-lg-5 col-md-12 footer-info">
            <a href="#" class="logo d-flex align-items-center">
              <img src="<?= base_url() ?>/tema/assets/img/logo.png" alt="">
              <h2>Saterskrim Polres Sumbawa</h2>
            </a>
            <p>Ikuti Perkembangan Informasi Terkini melalui Media Sosial Satreskrim Polres Sumbawa.</p>
            <div class="social-links mt-3">
              <a href="https://www.facebook.com/satreskrim.polressumbawa" class="facebook"><i class="bi bi-facebook"></i></a>
              <a href="https://www.instagram.com/satreskrim.ressumbawa/" class="instagram"><i class="bi bi-instagram bx bxl-instagram"></i></a>
              <a href="https://www.youtube.com/channel/UC2KmMKwLlXpte8I1kvy3dbA/featured" class="youtube"><i class="bi bi-youtube bx bxl-youtube"></i></a>
            </div>
            <img width="400px" src="<?= base_url() ?>/tema/assets/img/presisi.png" alt="">
          </div>

          <div class="col-lg-2 col-6 footer-links">
            <h4>Website Resmi Polres Sumbawa</h4>
            <ul>
              <li><i class="bi bi-chevron-right"></i> <a href="https://sumbawa.ntb.polri.go.id">Polres Sumbawa</a></li>
            </ul>
          </div>

          <div class="col-lg-2 col-6 footer-links">
            <h4>Pelayanan Kami</h4>
            <ul>
              <li><i class="bi bi-chevron-right"></i> <a href="<?= base_url('login/hilang_stnk') ?>">Pembuatan Kehilangan STNK / BPKB</a></li>
              <li><i class="bi bi-chevron-right"></i> <a href="<?= base_url('login/rck') ?>">Pembuatan Rekomndasi Catatan Kriminal (RCK)</a></li>
              <li><i class="bi bi-chevron-right"></i> <a href="<?= base_url('login/blokir_kendaraan') ?>">Pembuatan Blokir Kendaraan Bermotor</a></li>
            </ul>
          </div>

          <div class="col-lg-3 col-md-12 footer-contact text-center text-md-start">
            <h4>Kontak Kami</h4>
            <p>
              Jln Hasanuddin No. 105 <br>
              Kelurahan Bugis<br>
              Kecamatan Sumbawa <br>
              Kabupaten Sumbawa <br><br>
              <strong>Email:</strong> satreskrim.ressumbawa@gmail.com<br>
            </p>

          </div>

        </div>
      </div>
    </div>

    <div class="container">
      <div class="copyright">
        Copyright &copy; <strong><span>2021 Satreskrim Polres Sumbawa</span></strong>. All Rights Reserved, Powered By <a href="https://mr-leong.com">Mr Leong.</a>
      </div>
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="<?= base_url() ?>/tema/assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
  <script src="<?= base_url() ?>/tema/assets/vendor/aos/aos.js"></script>
  <script src="<?= base_url() ?>/tema/assets/vendor/php-email-form/validate.js"></script>
  <script src="<?= base_url() ?>/tema/assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="<?= base_url() ?>/tema/assets/vendor/purecounter/purecounter.js"></script>
  <script src="<?= base_url() ?>/tema/assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="<?= base_url() ?>/tema/assets/vendor/glightbox/js/glightbox.min.js"></script>

  <!-- Template Main JS File -->
  <script src="<?= base_url() ?>/tema/assets/js/main.js"></script>

</body>


</html>
<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<!-- Jquery UI -->
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">