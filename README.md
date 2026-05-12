# 🎯 O que esse efeito faz?

###### Quando o usuário:
- Começa no topo → header grande
- Rola a página → header diminui
- Geralmente:
    - Reduz altura
    - Reduz padding
    - Diminui logo
    - Adiciona sombra
    - Altera background/transparência

###### Esse padrão é MUITO usado em:
- Landing Pages
- Dashboards
- E-commerces
- Sites Institucionais
- SaaS
- Blogs Modernos

---

## ✅ Exemplo moderno (HTML + CSS3 + JS)
```html5
HTML5
    <header id="header">
        <div class="logo">
            Minha Logo
        </div>

        <nav>
            <a href="#">Home</a>
            <a href="#">Sobre</a>
            <a href="#">Contato</a>
        </nav>
    </header>

    <section class="hero">
        <h1>Conteúdo da página</h1>
    </section>
```

```css3
CSS3
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    height:3000px;
    font-family:Arial;
}

/* HEADER NORMAL */
#header{
    position:fixed;
    top:0;
    left:0;
    width:100%;
    
    display:flex;
    justify-content:space-between;
    align-items:center;

    padding:30px 60px;

    background:#ffffff;

    transition:all .3s ease;

    z-index:999;
}

/* LOGO */
#header .logo{
    font-size:32px;
    font-weight:bold;

    transition:all .3s ease;
}

/* HEADER MENOR */
#header.shrink{
    padding:12px 60px;

    box-shadow:0 2px 10px rgba(0,0,0,.08);

    background:rgba(255,255,255,.95);

    backdrop-filter:blur(10px);
}

/* LOGO MENOR */
#header.shrink .logo{
    font-size:22px;
}
```

```javascript
JavaScript
window.addEventListener('scroll', function(){

    const header = document.getElementById('header');

    if(window.scrollY > 100){
        header.classList.add('shrink');
    }else{
        header.classList.remove('shrink');
    }

});
```

---

## 🧠 Como funciona tecnicamente?
1️⃣ window.scrollY
- Captura quantos pixels o usuário rolou.

2️⃣ classList.add()
- Adiciona uma classe CSS dinamicamente.

3️⃣ transition
- Cria animação suave.

---

## ✅ Melhorias modernas usadas hoje
🔥 Adicionar transparência no topo

Muito comum:
```css3
CSS3
background:transparent;
```

E depois no scroll:
```css3
CSS3
background:#fff;
```

🔥 Blur moderno (Glassmorphism)
```css3
CSS3
backdrop-filter:blur(12px);
```

---

## 🔥 Auto hide header

###### Quando rola pra baixo:
- header some

###### Quando rola pra cima:
- reaparece

###### Isso é chamado de:
- Auto Hide Sticky Header

---

## 🎯 Termos que você pode pesquisar
- Sticky Header
- Shrink Header on Scroll
- Dynamic Navbar
- Scroll Responsive Header
- Smart Navbar
- Auto Hide Header
- Floating Header
- Glassmorphism Header

---

## ✅ UX/UI moderna

###### Hoje os headers modernos costumam usar:

| Efeito	        | Objetivo          |
|-------------------|-------------------|
| Shrink    	    | ganhar espaço     |
| Blur  	        | sofisticação      |
| Shadow    	    | separar conteúdo  |
| Transparency      | visual clean      |
| Hide on scroll    | foco no conteúdo  |