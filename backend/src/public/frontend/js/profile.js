document.getElementById('editProfileImage')?.addEventListener('change', e=>{
    const f=e.target.files?.[0]; if(!f) return;
    const r=new FileReader();
    r.onload=ev=>{ document.getElementById('profilePicture').src = ev.target.result; };
    r.readAsDataURL(f);
});