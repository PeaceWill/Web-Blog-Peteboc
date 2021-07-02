const previewImage = (selectorImage, selectorPreview) => {
    const uploadAvatar = document.querySelector(selectorImage);
    const avatarPreview = document.querySelector(selectorPreview); 
    uploadAvatar.addEventListener('change', () => { 
        const file = uploadAvatar.files[0];
        if (file) {
            const fileReader = new FileReader();
            fileReader.readAsDataURL(file);
            fileReader.addEventListener('load', () => {
                avatarPreview.src = fileReader.result;
            });
        }
    });
}

export {previewImage}