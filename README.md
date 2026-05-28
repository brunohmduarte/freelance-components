# Componente Accordion

Um componente de acordeão responsivo e acessível, construído com HTML, CSS e JavaScript puro. Permite exibir e ocultar conteúdo de forma interativa com animações suaves.

## 📋 Características

- ✅ **Responsivo**: Adapta-se a diferentes tamanhos de tela
- ✅ **Animações suaves**: Transições CSS para abrir/fechar itens
- ✅ **Ícones dinâmicos**: Rotação de ícone chevron ao expandir/recolher
- ✅ **Sem dependências externas**: Apenas Font Awesome para ícones
- ✅ **Fácil de personalizar**: CSS modular e bem estruturado
- ✅ **Acessível**: Usa elementos semânticos HTML5
- ✅ **Leve e rápido**: JavaScript vanilla, sem frameworks

## 🏗️ Estrutura do Componente

### Estrutura HTML

```html
<div class="accordion">
    <div class="accordion-item">
        <button type="button" class="accordion-header">
            <span>Título do Item</span>
            <i class="fa-solid fa-chevron-down"></i>
        </button>
        <div class="accordion-content">
            <p>Conteúdo do item...</p>
        </div>
    </div>
    <!-- Mais itens... -->
</div>
```

**Elementos principais:**
- `.accordion`: Contêiner principal
- `.accordion-item`: Cada item do acordeão
- `.accordion-header`: Botão clicável (título do item)
- `.accordion-content`: Conteúdo escondido/visível

### Classes CSS

| Classe | Descrição |
|--------|-----------|
| `.accordion` | Container principal do acordeão |
| `.accordion-item` | Item individual |
| `.accordion-header` | Botão do header (sempre visível) |
| `.accordion-content` | Conteúdo do item (oculto/visível) |
| `.show` | Classe adicionada ao item quando expandido |

### Funcionamento JavaScript

O script JavaScript adiciona um event listener a cada item:

```javascript
const accordionItems = document.querySelectorAll('.accordion-item');

accordionItems.forEach(accordion => {
    accordion.addEventListener('click', () => {
        accordion.classList.toggle('show');       
    });
});
```

**Comportamento:**
- Ao clicar no header, a classe `.show` é alternada
- A CSS controla a animação de abertura/fechamento
- O ícone rotaciona 90° quando expandido

## 🎨 Estilos Principais

### Dimensões
- **Largura**: 500px (responsiva em dispositivos menores)
- **Gap entre itens**: 1em
- **Padding do header**: 1em

### Cores
- **Fundo body**: `#f5f5f5`
- **Fundo item**: `#fff` (branco)
- **Fundo header padrão**: `transparent`
- **Fundo header hover/ativo**: `#e0e0e0`

### Animações
- **Transição de max-height**: 0.3s ease
- **Rotação do ícone**: 0.3s ease (90deg)
- **Borda inferior**: 1px solid #ddd

## 📱 Responsividade

O componente é responsivo graças ao uso de:
- `flexbox` para layout
- `width: 100%` para itens adaptáveis
- Meta tag viewport: `<meta name="viewport" content="width=device-width, initial-scale=1.0">`

Para melhorar em telas pequenas, adicione media queries:

```css
@media (max-width: 768px) {
    .accordion {
        width: 100%;
        padding: 0 1em;
    }
}
```

## 🔧 Como Usar

### 1. Incluir no seu projeto

```html
<!-- No <head> -->
<link rel="stylesheet" href="./assets/css/styles.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">

<!-- No final do <body> -->
<script src="./assets/js/scripts.js"></script>
```

### 2. Estrutura HTML

Copie e adapte a estrutura de `.accordion-item` conforme necessário.

### 3. Personalizar

Modifique o CSS para mudar cores, tamanhos e animações.

## 🎯 Exemplo de Uso Completo

```html
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acordeão</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
</head>
<body>
    <div class="container">
        <h1>Perguntas Frequentes</h1>
        <div class="accordion">
            <div class="accordion-item">
                <button type="button" class="accordion-header">
                    <span>O que é um acordeão?</span>
                    <i class="fa-solid fa-chevron-down"></i>
                </button>
                <div class="accordion-content">
                    <p>Um acordeão é um componente UI que permite expandir/recolher seções de conteúdo.</p>
                </div>
            </div>
        </div>
    </div>
    <script src="scripts.js"></script>
</body>
</html>
```

## 📦 Dependências

- **Font Awesome 7.0.1**: CDN para ícones chevron
- **Nenhuma dependência JavaScript**: Código vanilla

## 🌐 Compatibilidade

| Navegador | Versão Mínima |
|-----------|---------------|
| Chrome | 60+ |
| Firefox | 55+ |
| Safari | 12+ |
| Edge | 79+ |

## 🎨 Personalização

### Mudar cor do hover

```css
.accordion-header:hover {
    background: #seu-color;
}
```

### Ajustar velocidade de animação

```css
.accordion-header i,
.accordion-content {
    transition: 0.5s ease; /* Aumentar para 0.5s */
}
```

### Mudar tamanho do acordeão

```css
.accordion {
    width: 800px; /* Ajuste conforme necessário */
}
```

### Ajustar altura máxima do conteúdo

```css
.accordion-item.show .accordion-content {
    max-height: 300px; /* Aumentar se conteúdo for maior */
}
```

## 🔍 Possíveis Melhorias

1. **Suporte a teclado**: Implementar navegação por setas
2. **Conteúdo dinâmico**: Carregar conteúdo via AJAX
3. **Temas**: Adicionar variáveis CSS para múltiplos temas
4. **Acessibilidade**: Adicionar ARIA labels

## 📝 Notas

- A altura máxima do conteúdo é definida como `200px`. Ajuste conforme seu conteúdo
- O componente usa `overflow: hidden` para esconder o conteúdo além da altura máxima
- Ícones da Font Awesome são escaláveis e customizáveis

