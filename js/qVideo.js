
/* Feature detection */
function hasGetUserMedia() {
  return !!(navigator.mediaDevices && navigator.mediaDevices.getUserMedia);
}

if (hasGetUserMedia()) {
  // Good to go!
} else {
  alert('getUserMedia() is not supported by your browser');
}

function uploadMedia(u_id, mediaBlob) {
  var fd = new FormData();
  fd.append('u_id', u_id);
  fd.append('media', mediaBlob);
  $.ajax({
      type: 'POST',
      url: '/upload.php',
      data: fd,
      processData: false,
      contentType: false
  }).done(function(data) {
         console.log(data);
  });
}
