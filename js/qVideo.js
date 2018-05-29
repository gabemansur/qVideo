class QVideo {

  constructor(video, u_id, qInstance) {
    // Set default constraints
    this.constraints = {
      video: true,
      audio: true,
    };

    this.options = {
      mimeType: 'video/webm', // or video/webm\;codecs=h264 or video/webm\;codecs=vp9
      audioBitsPerSecond: 128000,
      videoBitsPerSecond: 128000,
      bitsPerSecond: 128000 // if this line is provided, skip above two
    };

    this.uploadUrl = 'upload.php';

    // The video HTML element
    this.video = video;

    // Reference to the Qualtrics object, in case we want to call Qualtrics functions from this class
    this.q = qInstance;

    this.u_id = u_id;

    this.recordRTC = null;
    this.recordedBlob = null;
    this.stream = null;

  }

  hasGetUserMedia() {
    return !!(navigator.mediaDevices && navigator.mediaDevices.getUserMedia);
  }

  setConstraints(constraints) {
    this.constraints = constraints;
  }

  getContstraints() {
    return this.constraints;
  }

  setOptions(options) {
    this.options = options;
  }

  getOptions() {
    return this.options;
  }


  startRecording() {
    var self = this; // so we have a reference to our QVideo instance in the callback
    console.log(this.options);
    navigator.mediaDevices.getUserMedia(this.constraints)
      .then(function(stream) {
        self.handleSuccess(stream)
      })
      .catch(function(error) {
        self.handleError(error)
      });
  }

  handleSuccess(stream) {
    this.stream = stream;

    if(!!this.video){
      this.video.muted = true;
      this.video.srcObject = stream;
    }

    this.recordRTC = RecordRTC(stream, this.options);
    this.recordRTC.startRecording();
  }

  handleError(error) {
    console.error('Error: ', error);
    $("#msg").show();
    $("#msg").attr('class', 'qvideo-msg qvideo-error');
    $("#msg").html('Error: ' + error);
  }


  stopRecording() {
    var self = this; // so we have a reference to our QVideo instance
    if (this.stream!= null) {
      this.stream.getTracks().map(function (val) {
      val.stop();
      });
    }
    this.recordRTC.stopRecording(function() {
        // Ideally, we would shut off the web cam here
        self.recordedBlob = self.recordRTC.getBlob();
        self.uploadMedia();
      });
  }

  uploadMedia() {
    var fd = new FormData();
    var self = this; // so we have a reference to our QVideo instance
    fd.append('u', this.u_id);
    fd.append('media', this.recordedBlob);
    $.ajax({
        type: 'POST',
        url: this.uploadUrl,
        data: fd,
        processData: false,
        contentType: false})
        .done(function(data) {
           self.handleUploadResult(data);
    });
  }

  handleUploadResult(result) {
    if(result == 'Success'){
      $("#msg").html('Video uploaded successfully!');
      $("#msg").show();
    }
    else if(result == 'Error saving file to server') {
      $("#err").html('There was an error saving the file!');
      $("#err").show();
    }
    else if(result == 'Error uploading file') {
      $("#err").html('There was an error uploading the file!');
      $("#err").show();
    }
    $("video").hide();
  }
}
