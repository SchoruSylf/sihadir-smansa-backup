// document.addEventListener('DOMContentLoaded', (event) => {
//   feather.replace();

//   const controls = document.querySelector('.controls');
//   const cameraOptions = document.querySelector('.video-options>select');
//   const video = document.querySelector('video');
//   const canvas = document.querySelector('canvas');
//   const screenshotImage = document.getElementById('taken_pict');
//   const buttons = [...controls.querySelectorAll('button')];
//   const image_take = document.querySelector('#image_take');
//   const image_form = document.querySelector('#image_form');

//   let streamStarted = false;

//   const [play, pause, screenshot] = buttons;

//   const constraints = {
//     video: {
//       width: {
//         min: 1280,
//         ideal: 1920,
//         max: 2560,
//       },
//       height: {
//         min: 720,
//         ideal: 1080,
//         max: 1440
//       },
//       facingMode: 'user'
//     }
//   };

//   cameraOptions.onchange = () => {
//     const updatedConstraints = {
//       ...constraints,
//       deviceId: {
//         exact: cameraOptions.value
//       }
//     };

//     startStream(updatedConstraints);
//   };

//   play.onclick = () => {
//     if (streamStarted) {
//       video.play();
//       play.classList.add('d-none');
//       pause.classList.remove('d-none');
//       return;
//     }
//     if ('mediaDevices' in navigator && navigator.mediaDevices.getUserMedia) {
//       const updatedConstraints = {
//         ...constraints,
//         deviceId: {
//           exact: cameraOptions.value
//         }
//       };
//       startStream(updatedConstraints);
//     }
//   };

//   const pauseStream = () => {
//     video.pause();
//     play.classList.remove('d-none');
//     pause.classList.add('d-none');
//   };

//   const doScreenshot = () => {
//     canvas.width = video.videoWidth;
//     canvas.height = video.videoHeight;
//     canvas.getContext('2d').drawImage(video, 0, 0);
//     const imageData = canvas.toDataURL('image/webp');
//     screenshotImage.src = imageData;
//     image_take.value = imageData;
//     image_form.submit();
//   };

//   pause.onclick = pauseStream;
//   screenshot.onclick = doScreenshot;

//   const startStream = async (constraints) => {
//     try {
//       const stream = await navigator.mediaDevices.getUserMedia(constraints);
//       handleStream(stream);
//     } catch (error) {
//       console.error('Error accessing media devices.', error);
//     }
//   };

//   const handleStream = (stream) => {
//     video.srcObject = stream;
//     play.classList.add('d-none');
//     pause.classList.remove('d-none');
//     screenshot.classList.remove('d-none');
//     streamStarted = true;
//   };

//   const getCameraSelection = async () => {
//     try {
//       const devices = await navigator.mediaDevices.enumerateDevices();
//       const videoDevices = devices.filter(device => device.kind === 'videoinput');
//       const options = videoDevices.map(videoDevice => {
//         return `<option value="${videoDevice.deviceId}">${videoDevice.label}</option>`;
//       });
//       cameraOptions.innerHTML = options.join('');
//     } catch (error) {
//       console.error('Error fetching devices.', error);
//     }
//   };

//   getCameraSelection();
// });
document.addEventListener('DOMContentLoaded', (event) => {
  feather.replace();

  const controls = document.querySelector('.controls');
  const cameraOptions = document.querySelector('.video-options>select');
  const video = document.querySelector('video');
  const canvas = document.querySelector('canvas');
  const screenshotImage = document.getElementById('taken_pict');
  const buttons = [...controls.querySelectorAll('button')];
  const image_take = document.querySelector('#image_take');
  const image_form = document.querySelector('#image_form');

  let streamStarted = false;

  const [play, screenshot] = buttons;

  const constraints = {
    video: {
      width: {
        min: 1280,
        ideal: 1920,
        max: 2560,
      },
      height: {
        min: 720,
        ideal: 1080,
        max: 1440
      },
      facingMode: 'user'
    }
  };

  cameraOptions.onchange = () => {
    const updatedConstraints = {
      ...constraints,
      deviceId: {
        exact: cameraOptions.value
      }
    };

    startStream(updatedConstraints);
  };

  play.onclick = () => {
    if (streamStarted) {
      video.play();
      return;
    }
    if ('mediaDevices' in navigator && navigator.mediaDevices.getUserMedia) {
      const updatedConstraints = {
        ...constraints,
        deviceId: {
          exact: cameraOptions.value
        }
      };
      startStream(updatedConstraints);
    }
  };

  const doScreenshot = () => {
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    canvas.getContext('2d').drawImage(video, 0, 0);
    const imageData = canvas.toDataURL('image/webp');
    screenshotImage.src = imageData;
    image_take.value = imageData;
    image_form.submit();
  };

  screenshot.onclick = doScreenshot;

  const startStream = async (constraints) => {
    try {
      const stream = await navigator.mediaDevices.getUserMedia(constraints);
      handleStream(stream);
    } catch (error) {
      console.error('Error accessing media devices.', error);
    }
  };

  const handleStream = (stream) => {
    video.srcObject = stream;
    play.classList.add('d-none');
    screenshot.classList.remove('d-none');
    streamStarted = true;
  };

  const getCameraSelection = async () => {
    try {
      const devices = await navigator.mediaDevices.enumerateDevices();
      const videoDevices = devices.filter(device => device.kind === 'videoinput');
      const options = videoDevices.map(videoDevice => {
        return `<option value="${videoDevice.deviceId}">${videoDevice.label}</option>`;
      });
      cameraOptions.innerHTML = options.join('');
    } catch (error) {
      console.error('Error fetching devices.', error);
    }
  };
  
  function loadSelect() {
    // Function to load the available cameras into the select options
    navigator.mediaDevices.enumerateDevices()
      .then(devices => {
        const videoSelect = document.querySelector('.video-options select');
        devices.forEach(device => {
          if (device.kind === 'videoinput') {
            const option = document.createElement('option');
            option.value = device.deviceId;
            option.text = device.label || `Camera ${videoSelect.length + 1}`;
            videoSelect.appendChild(option);
          }
        });
      });
  }

  getCameraSelection();
});
