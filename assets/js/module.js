function toRp(angka){
    var rev     = parseInt(angka, 10).toString().split('').reverse().join('');
    var rev2    = '';
    for(var i = 0; i < rev.length; i++){
        rev2  += rev[i];
        if((i + 1) % 3 === 0 && i !== (rev.length - 1)){
            rev2 += '.';
        }
    }
    return 'Rp. ' + rev2.split('').reverse().join('') ;
}

function toRibuan(angka){
    var rev     = parseInt(angka, 10).toString().split('').reverse().join('');
    var rev2    = '';
    for(var i = 0; i < rev.length; i++){
        rev2  += rev[i];
        if((i + 1) % 3 === 0 && i !== (rev.length - 1)){
            rev2 += '.';
        }
    }
    return  rev2.split('').reverse().join('');
}

function formatRibuan(objek) {
   a = objek.value;
   b = a.replace(/[^\d]/g,"");
   c = "";
   panjang = b.length;
   j = 0;
   for (i = panjang; i > 0; i--) {
     j = j + 1;
     if (((j % 3) == 1) && (j != 1)) {
       c = b.substr(i-1,1) + "." + c;
     } else {
       c = b.substr(i-1,1) + c;
     }
   }
   objek.value = c;
}


// Standard Form
$('#form_standar').validate({
	rules: {
		PASSWORD: "required",
		REPASS: {
		  equalTo: "#PASSWORD"
		}
	},
	submitHandler: function(form) {	
		
		
		$.ajax({
			url: base_url+''+uri_1+'/'+uri_2+'_data',
			type:'POST',
			dataType:'json',
			data: $('#form_standar').serialize(),
			beforeSend: function(){	
				$('#loading').show();
				$('#pesan_error').hide();
			},
			success: function(data){
				if( data.status ){	
					$('.main-footer').append('<div class="modal fade" id="container-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="false"><div class="modal-dialog" role="document"><div class="modal-content"><div class="modal-header"><h4 class="modal-title" id="myModalLabel">Pesan Pemberitahuan</h4></div><div class="modal-body"><b>Data berhasil disimpan.</b></div><div class="modal-footer"><a href="'+data.redirect_link+'"> <button type="button" class="btn btn-primary">Ok</button></a></div></div></div></div>');
					$('#container-modal').modal('show');
					
				}
				else{				
					$('#loading').hide(); $('#pesan_error').show(); $('#pesan_error').html(data.pesan);					 
				}
			},
			error : function(data) {
				$('#pesan_error').html('maaf telah terjadi kesalahan dalam program, silahkan anda mengakses halaman lainnya.'); $('#pesan_error').show(); $('#loading').hide();
				//$('#pesan_error').html( '<h3>Error Response : </h3><br>'+JSON.stringify( data ));
			}
		})
	}
});



$('#PASSWORD_LOGIN').keydown(function(event){ 
    var keyCode = (event.keyCode ? event.keyCode : event.which);   
    if (keyCode == 13) {
        $('#startSearch').trigger('click');
    }
});

$('#form_login').validate({
	submitHandler: function(form) {	
		$.ajax({
			url: base_url+'login/login_data',
			type:'POST',
			dataType:'json',
			data: $('#form_login').serialize(),
			beforeSend: function(){	
				$('#loading_login').show();
				$('#pesan_error_login').hide();
			},
			success: function(data){
				if( data.status ){		
					if($('#forAction').val()=='disableModal'){
						$('#modalLogin').hide('scale',function(){
							location.reload();
						});					
					}
					else{
						$('#modalLogin').slideUp('scale',function(){
							location.href= data.redirect_link;
						});						
					}
				}
				else{				
					$('#loading_login').hide(); $('#pesan_error_login').show(); $('#pesan_error_login').html(data.pesan);					 
				}
			},
			error : function(data) {
				$('#pesan_error_login').html('maaf telah terjadi kesalahan dalam program, silahkan anda mengakses halaman lainnya.'); $('#pesan_error_login').show(); $('#loading_login').hide();
				//$('#pesan_error').html( '<h3>Error Response : </h3><br>'+JSON.stringify( data ));
			}
		})
	}
});



function tampil_pesan_hapus(pesan_hapus,link_hapus){
	$('.main-footer').append('<div class="modal fade" id="container-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="false"><div class="modal-dialog" role="document"><div class="modal-content"><div class="modal-header"><h4 class="modal-title" id="myModalLabel">Pesan Konfirmasi</h4></div><div class="modal-body">Apakah anda yakin akan menghapus data <b>'+pesan_hapus+'</b> ..?</div><div class="modal-footer"><div class="pull-left"><button type="button" class="btn btn-warning" data-dismiss="modal">Tidak</button></div><a href="'+link_hapus+'"> <button type="button" class="btn btn-primary">Ya</button></a></div></div></div></div>');
	$('#container-modal').modal('show');

}

function showModalLogOut(link){
	$('.main-footer').append('<div class="modal fade" id="modalLogout" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="false"><div class="modal-dialog" role="document"><div class="modal-content"><div class="modal-header"><h4 class="modal-title" id="myModalLabel">Pesan Konfirmasi</h4></div><div class="modal-body">Apakah anda yakin akan keluar  ..?</div><div class="modal-footer"><div class="pull-left"><button type="button" class="btn btn-warning" data-dismiss="modal">Tidak</button></div><a href="'+link+'"> <button type="button" class="btn btn-primary">Ya</button></a></div></div></div></div>');
	$('#modalLogout').modal('show');

}

function checkAllDeleteButton(){
	if ($('#checkAllDelete').is(':checked')) {
		$('input:checkbox').prop('checked', true);
	}
	else{
		$('input:checkbox').prop('checked', false);
	}
}

$("#NAMA_KARYAWAN_AUTOCOMPLETE").autocomplete({
	source:base_url+'karyawan/search_karyawan/',
	select: function (e, ui) {
		$("#ID_KARYAWAN").val(ui.item.id_karyawan);
	}
});

$("#NAMA_BARANG_AUTOCOMPLETE").autocomplete({
	source:base_url+'barang/search_barang/',
	select: function (e, ui) {
		hilang_jumlah_barang_form();
		
		$("#JUMLAH_QTY_FORM").focus();
		$("#ID_BARANG_FORM").val(ui.item.id_barang);
		$("#SATUAN_BARANG_FORM").val(ui.item.satuan_barang);
	}
});




$('#form_upload').ajaxForm({
	url: base_url+'save_upload/foto/',
	type: 'post',
	dataType: 'json',
	resetForm: false,
	beforeSubmit: function() {
		$('#loading_input_foto_karyawan').show();
	},
	success: function(data) {
		if(data.status){
			
		}
		else{
			$('#pesan_error_input_foto_karyawan').html(data.pesan);
			$('#pesan_error_input_foto_karyawan').show();
		}
	},
	error : function(data) {
		alert("error .. return bukan Json");
	}
});

function ambil_kartu(id_t_order){
	
	$('#id_order_ambil_kartu').val(id_t_order);
	
       // alert();
 
	    $('#modal_ambil_kartu').modal('show');
		
		
		var delayInMilliseconds = 500; //1 second

		setTimeout(function() {
			$('#nomor_rfid').focus();
		}, delayInMilliseconds);
}

function focus_kartu(){	
	$('#nomor_rfid').focus();
}




// Standard Form
$('#form_ambil_kartu').validate({
	submitHandler: function(form) {	
		
		
		$.ajax({
			url: base_url+'trans_tiket/ambil_tiket',
			type:'POST',
			dataType:'json',
			data: $('#form_ambil_kartu').serialize(),
			beforeSend: function(){	
				$('#loading').show();
				$('#pesan_error').hide();
			},
			success: function(data){
				if( data.status ){	
					location.href=base_url+'trans_tiket'
					
				}
				else{				
					$('#loading').hide(); $('#pesan_error').show(); $('#pesan_error').html(data.pesan);					 
				}
			},
			error : function(data) {
				$('#pesan_error').html('maaf telah terjadi kesalahan dalam program, silahkan anda mengakses halaman lainnya.'); $('#pesan_error').show(); $('#loading').hide();
				//$('#pesan_error').html( '<h3>Error Response : </h3><br>'+JSON.stringify( data ));
			}
		})
	}
});

function cekPetugasLoket(){
	if($('#ID_KATEGORI_USER').val()=='2'){
		$('#divLoket').show();
		$('#ID_BARANG').addClass('required');
	}
	else{
		
		$('#divLoket').hide();
		$('#ID_BARANG').removeClass('required');
		$('#ID_BARANG').val('');
	}
}


$('#form_tiket').validate({
	submitHandler: function(form) {	
		
		
		$.ajax({
			url: base_url+''+uri_1+'/'+uri_2+'_data',
			type:'POST',
			dataType:'html',
			data: $('#form_tiket').serialize(),
			beforeSend: function(){	
				$('#loading').show();
				$('#pesan_error').hide();
			},
			success: function(data){
							
				$('#loading').hide(); 
				$('#pesanTiketMasuk').show(); 
				$('#pesanTiketMasuk').html(data);	
				
				$('#NOMOR_RFID').val('');					 
				$('#NOMOR_RFID').focus();					 
				
			}
		})
	}
});


$('#form_konfirmasi').validate({
	submitHandler: function(form) {	
		
		
		$.ajax({
			url: base_url+'konfirmasi/add_data',
			type:'POST',
			dataType:'json',
			data: $('#form_konfirmasi').serialize(),
				beforeSend: function(){	
				$('#loading').show();
				$('#pesan_error').hide();
			},
			success: function(data){
				if( data.status ){	
					if(uri_2 == 'add'){
						location.href=base_url+'trans_tiket';
					}
					else{
						location.href=base_url+'trans_tiket';
					}
					
				}
				else{				
					$('#loading').hide(); $('#pesan_error').show(); $('#pesan_error').html(data.pesan);					 
				}
			},
			error : function(data) {
				$('#pesan_error').html('maaf telah terjadi kesalahan dalam program, silahkan anda mengakses halaman lainnya.'); $('#pesan_error').show(); $('#loading').hide();
				//$('#pesan_error').html( '<h3>Error Response : </h3><br>'+JSON.stringify( data ));
			}
		})
	}
});


function konfirmasi_pembayaran_online(id_order,keterangan){
	
	$('#modal_konfirmasi_pembayaran_online').modal('show');
	$('#pesanKonfirmasi').html(keterangan);
	$('#id_order').val(id_order);
	
}


