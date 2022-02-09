var Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000
});

// ABRIR MODAL LOTE LOCAL
function abrirModalLoteLocal() {
  $('#lotelocalModal').modal();
}