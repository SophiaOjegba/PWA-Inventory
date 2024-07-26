const dbPromise = idb.openDB('equipment-store', 1, {
    upgrade(db) {
        if (!db.objectStoreNames.contains('equipments')) {
            const store = db.createObjectStore('equipments', {
                keyPath: 'equipment_number'
              });
              store.createIndex('name', 'name');;
        }
        if (!db.objectStoreNames.contains('uploads')) {
            const store = db.createObjectStore('uploads', { autoIncrement: true });
            store.createIndex('equipment_id', 'equipment_id');
            store.createIndex('updated_at', 'updated_at');
        }
    }
});

async function saveEquipment(equipment) {
    const db = await dbPromise;
    const tx = db.transaction('equipments', 'readwrite');
    tx.objectStore('equipments').put(equipment);
    await tx.done;
  }


function getEquipment(equipmentNumber) {
    return dbPromise.then(db => {
        const tx = db.transaction('equipments');
        const store = tx.objectStore('equipments');
        return store.get(equipmentNumber);
    });
}

async function saveUpload(upload) {
    const db = await dbPromise;
    const tx = db.transaction('uploads', 'readwrite');
    tx.objectStore('uploads').put(upload);
    await tx.done;
  }

//   function uploadFile(file, equipmentNumber) {
//     const formData = new FormData();
//     formData.append('file', file);
//     formData.append('equipment_id', equipmentNumber);
//     formData.append('_token', csrfToken);

//     fetch('/upload-file', {
//       method: 'POST',
//       body: formData
//     }).then(response => response.json())
//       .then(data => {
//         if (data.status === 'success') {
//           console.log('File uploaded successfully');
//           saveUpload({
//             equipment_id: equipmentNumber,
//             file_path: data.file_path,
//             updated_at: new Date().toISOString()
//           });
//         } else {
//           console.error('Failed to upload file');
//         }
//       })
//       .catch(error => console.error('Upload failed:', error));
//   }

function getUploads() {
    return dbPromise.then(db => {
        const tx = db.transaction('uploads');
        const store = tx.objectStore('uploads');
        return store.getAll();
    });
}
