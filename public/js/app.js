document.getElementById('searchForm').addEventListener('submit', function (e) {
    e.preventDefault();
    const equipmentNumber = document.getElementById('equipmentNumber').value;
    fetchEquipment(equipmentNumber);
});

document.getElementById('updateButton').addEventListener('click', function () {
    const equipmentNumber = document.getElementById('equipmentNumber').value;
    const name = document.getElementById('name').value;
    const description = document.getElementById('description').value;
    updateEquipment(equipmentNumber, name, description);
});

document.getElementById('uploadButton').addEventListener('click', function () {
    const fileInput = document.getElementById('fileInput');
    const equipmentNumber = document.getElementById('equipmentNumber').value;
    uploadFile(fileInput.files[0], equipmentNumber);
});

document.getElementById('syncButton').addEventListener('click', syncData);

const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

function fetchEquipment(equipmentNumber) {
    fetch(`/get-equipment?equipment_number=${equipmentNumber}`)
        .then(response => response.json())
        .then(data => {
            if (data) {
                document.getElementById('name').value = data.name || '';
                document.getElementById('description').value = data.description || '';
                saveEquipment(data);
            } else {
                alert('Equipment not found');
            }
        });
}



function updateEquipment(equipmentNumber, name, description) {
    fetch('/update-equipment', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
        body: JSON.stringify({ equipment_number: equipmentNumber, name: name, description: description })
    }).then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                alert('Equipment updated successfully');
                saveEquipment({ equipment_number: equipmentNumber, name: name, description: description });
            } else {
                alert('Failed to update equipment');
            }
        });
}

function uploadFile(file, equipmentNumber) {
    const formData = new FormData();
    formData.append('file', file);
    formData.append('equipment_id', equipmentNumber);
    formData.append('_token', csrfToken);

    fetch('/upload-file', {
      method: 'POST',
      body: formData
    }).then(response => response.json())
      .then(data => {
        if (data.status === 'success') {
          console.log('File uploaded successfully');
          saveUpload({
            equipment_id: equipmentNumber,
            file_path: data.file_path,
            updated_at: new Date().toISOString()
          });
        } else {
          console.error('Failed to upload file');
        }
      })
      .catch(error => console.error('Upload failed:', error));
  }


function syncData() {
    getUploads().then(uploads => {
        if (uploads.length > 0) {
            fetch('/sync-uploads', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                body: JSON.stringify({ uploads: uploads })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    console.log('Uploads synchronized successfully');
                } else {
                    console.error('Failed to synchronize uploads');
                }
            })
            .catch(error => console.error('Sync uploads failed:', error));
        } else {
            console.log('No uploads to sync');
        }
    })
    .then(() => {
        fetch('/fetch-all-equipments')
  .then(response => response.json())
  .then(data => {
    // Clear IndexedDB before updating with new data
    dbPromise.then(db => {
      const tx = db.transaction('equipments', 'readwrite');
      tx.objectStore('equipments').clear();
      return tx.done;
    })
    .then(() => {
      data.forEach(equipment => {
        saveEquipment(equipment);
      });
      console.log('Equipments synchronized successfully');
    });
  })
  .catch(error => console.error('Failed to fetch equipments:', error));

    });
}
