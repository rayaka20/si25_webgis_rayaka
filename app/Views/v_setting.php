<div class="col-md-12">
            <div class="card card-outline card-primary">
              <div class="card-header">
                <h3 class="card-title"><?= $judul ?></h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
                <!-- /.card-tools -->
              </div>
              <!-- /.card-header -->
              <div class="card-body">

              <?php 
              if(session()->getFlashdata('pesan')){
                echo '<div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  <h5><i class="icon fas fa-check"></i>';
                echo session()->getFlashdata('pesan');
                echo '</h5></div>';
              }
              ?>

                <?php echo form_open('Admin/UpdateSetting')  ?>

                

                  <div class="row">
                    <div class="col-sm-7">
                    <div class="form-group">
                    <label>Nama Website</label>
                    <input name="nama_web" value="<?= $web['nama_web'] ?>"class="form-control"placeholder="Nama Website" required>
                  </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                    <label>Coordinat Wilayah</label>
                    <input name="coordinat_wilayah" value="<?= $web['coordinat_wilayah'] ?>"class="form-control"placeholder="Coordinat Wilayah" required>
                        </div>   
                    </div>

                    <div class="col-sm-2">
                        <div class="form-group">
                    <label>Zoom View</label>
                    <input type="number" value="<?= $web['zoom_view'] ?>"name="zoom_view" min="0" max="20" class="form-control"placeholder="Zoom View" required>
                  </div>
                    </div>
                  </div>


                  <button class="btn btn-primary" type="submit">Simpan</button>
                  

                  

                <?php echo form_close() ?>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>


          <div class="col-md-12">
            <div id="map" style="width: 100%; height: 800px;"></div>
                </div>  


    <script>
    var peta1 = L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
		attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
			'<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
			'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
		id: 'mapbox/streets-v11'
	});

    var peta2 = L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
		attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
			'<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
			'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
		id: 'mapbox/satellite-v9'
	});


    var peta3 = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
		attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
	});

    var peta4 = L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
		attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
			'<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
			'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
		id: 'mapbox/dark-v10'
	});

      
  

    const map = L.map('map', {
	    center: [<?= $web['coordinat_wilayah'] ?>],
	    zoom: <?= $web['zoom_view'] ?>,
	    layers: [peta3]
});

    const baseMaps = {
	    'OpenStreetMap': peta1,
	    'satelite': peta2,
        'streets': peta3,
        'night': peta4
    };

    var layerControl = L.control.layers(baseMaps).addTo(map);
</script>