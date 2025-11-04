<div id="map" style="width: 100%; height: 800px;"></div>

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

	<?php foreach ($wilayah as $key => $value) { ?>
        L.geoJSON(<?= $value['geojson'] ?>, {
            fillColor: '<?= $value['warna'] ?>',
            fillOpacity: 0.5,
        })
        .bindPopup("<b><?= $value['nama_wilayah'] ?></b>")
        .addTo(map);
    <?php } ?>

	<?php foreach ($sekolah as $key => $value) { ?>
	var Icon = L.icon({
    iconUrl: '<?= base_url('marker/'. $value['marker'])?>',
    iconSize:     [35, 50], // size of the icon
});

        L.marker([<?= $value['coordinat'] ?>], {
			icon: Icon
		})
		.bindPopup("<img src='<?= base_url('foto/'. $value['foto']) ?>' width='150px' height='100px'><br>" +
		"<b><?= $value['nama_sekolah'] ?></b><br>" +
		"Akreditasi <?= $value['akreditasi'] ?><br>" +
		"<?= $value['status'] ?><br><br>" +
		"<a href='<?= base_url('Home/DetailSekolah/'. $value['id_sekolah']) ?>' class='btn btn-primary btn-xs text-white'>Detail</a>") 
        .addTo(map);
    <?php } ?>
</script>