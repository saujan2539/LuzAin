let body = document.body;

let profile = document.querySelector('.header .flex .profile');

document.querySelector('#user-btn').onclick = () =>{
   profile.classList.toggle('active');
   searchForm.classList.remove('active');
}

let searchForm = document.querySelector('.header .flex .search-form');

document.querySelector('#search-btn').onclick = () =>{
   searchForm.classList.toggle('active');
   profile.classList.remove('active');
}

let sideBar = document.querySelector('.side-bar');

document.querySelector('#menu-btn').onclick = () =>{
   sideBar.classList.toggle('active');
   body.classList.toggle('active');
}

document.querySelector('.side-bar .close-side-bar').onclick = () =>{
   sideBar.classList.remove('active');
   body.classList.remove('active');
}

document.querySelectorAll('input[type="number"]').forEach(InputNumber => {
   InputNumber.oninput = () =>{
      if(InputNumber.value.length > InputNumber.maxLength) InputNumber.value = InputNumber.value.slice(0, InputNumber.maxLength);
   }
});

window.onscroll = () =>{
   profile.classList.remove('active');
   searchForm.classList.remove('active');

   if(window.innerWidth < 1200){
      sideBar.classList.remove('active');
      body.classList.remove('active');
   }

}

let toggleBtn = document.querySelector('#toggle-btn');
let darkMode = localStorage.getItem('dark-mode');

const enabelDarkMode = () =>{
   toggleBtn.classList.replace('fa-sun', 'fa-moon');
   body.classList.add('dark');
   localStorage.setItem('dark-mode', 'enabled');
}

const disableDarkMode = () =>{
   toggleBtn.classList.replace('fa-moon', 'fa-sun');
   body.classList.remove('dark');
   localStorage.setItem('dark-mode', 'disabled');
}

if(darkMode === 'enabled'){
   enabelDarkMode();
}

toggleBtn.onclick = (e) =>{
   let darkMode = localStorage.getItem('dark-mode');
   if(darkMode === 'disabled'){
      enabelDarkMode();
   }else{
      disableDarkMode();
   }
}

/* --- scroll reveal animation (fade + slide up) --- */
(function(){
   if(!('IntersectionObserver' in window)) return;
   const targets = document.querySelectorAll('.box-container .box, .videos-container .box, .heading');
   if(targets.length === 0) return;
   const reset = (el) =>{
      el.style.opacity = '0';
      el.style.transform = 'translateY(2.5rem)';
      el.style.transition = 'opacity .6s ease, transform .6s ease';
   };
   targets.forEach(reset);
   const io = new IntersectionObserver((entries) =>{
      entries.forEach((entry) =>{
         if(entry.isIntersecting){
            const el = entry.target;
            el.style.opacity = '1';
            el.style.transform = 'translateY(0)';
            io.unobserve(el);
            setTimeout(() =>{
               el.style.transition = '';
               el.style.transform = '';
               el.style.opacity = '';
            }, 700);
         }
      });
   }, {threshold: .08, rootMargin: '0px 0px -40px 0px'});
   targets.forEach((el) => io.observe(el));
})();

/* --- auto-dismiss toasts --- */
(function(){
   document.querySelectorAll('.toast').forEach((toast) => {
      setTimeout(() => {
         toast.classList.add('hide');
         setTimeout(() => toast.remove(), 450);
      }, 3200);
   });
})();