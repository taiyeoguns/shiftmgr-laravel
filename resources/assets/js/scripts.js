//Scripts

$(".avatar").initial();

$(".alert")
  .not(".alert-important")
  .delay(4000)
  .slideUp(200, function() {
    $(this).alert("close");
  });
