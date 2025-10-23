# PhotoEvents - Plataforma de Venda de Fotos de Eventos

Uma plataforma Laravel para fotógrafos e clientes partilharem e adquirirem fotografias de eventos.

## Funcionalidades

### Para Fotógrafos
- **Dashboard**: Gerir álbuns de eventos
- **Criação de Álbuns**: Adicionar detalhes do evento (título, data, descrição, email do gestor)
- **Upload de Fotos**: Fazer upload de múltiplas fotos para cada álbum
- **Publicação**: Publicar álbuns para que os clientes possam aceder
- **Gestão**: Visualizar estatísticas e eliminar fotos

### Para Clientes
- **Acesso por Email**: Aceder aos álbuns usando o email do gestor
- **Visualização**: Ver todas as fotos do evento
- **Seleção**: Selecionar fotos para compra
- **Compra**: Escolher entre opções digitais ou impressão física
- **Checkout**: Finalizar compra com cálculo automático de preços

## Tecnologias Utilizadas

- **Laravel 12** - Framework PHP
- **Blade Templates** - Sistema de templates
- **Tailwind CSS v4** - Framework CSS
- **Vite** - Build tool
- **JavaScript Vanilla** - Interatividade
- **LocalStorage** - Persistência de dados (demo)

## Instalação

1. **Clone o repositório**
   ```bash
   git clone <repository-url>
   cd digitalartstudio
   ```

2. **Instale as dependências PHP**
   ```bash
   composer install
   ```

3. **Instale as dependências Node.js**
   ```bash
   npm install
   ```

4. **Configure o ambiente**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Compile os assets**
   ```bash
   npm run build
   # ou para desenvolvimento
   npm run dev
   ```

6. **Execute o servidor**
   ```bash
   php artisan serve
   ```

## Estrutura do Projeto

```
app/
├── Actions/Http/          # Actions para cada página
│   ├── IndexAction.php
│   ├── AuthAction.php
│   ├── DashboardAction.php
│   ├── AlbumDetailAction.php
│   ├── ClientAuthAction.php
│   └── ClientAlbumAction.php
└── ...

resources/
├── views/                 # Templates Blade
│   ├── layouts/
│   │   └── app.blade.php
│   ├── index.blade.php
│   ├── auth.blade.php
│   ├── dashboard.blade.php
│   ├── album-detail.blade.php
│   ├── client-auth.blade.php
│   └── client-album.blade.php
├── css/
│   └── app.css           # Estilos Tailwind CSS
└── js/
    ├── app.js
    └── bootstrap.js

routes/
└── web.php               # Rotas da aplicação
```

## Rotas Disponíveis

- `GET /` - Página inicial
- `GET /auth` - Autenticação do fotógrafo
- `GET /dashboard` - Dashboard do fotógrafo
- `GET /album/{id}` - Detalhes do álbum (fotógrafo)
- `GET /client-auth` - Autenticação do cliente
- `GET /client-album/{id}` - Visualização do álbum (cliente)

## Como Usar

### Para Fotógrafos

1. **Aceder à plataforma**: Vá para `/auth`
2. **Criar conta ou fazer login**: Use o formulário de autenticação
3. **Criar álbum**: No dashboard, clique em "Novo Álbum"
4. **Adicionar fotos**: No álbum, use "Upload Fotos"
5. **Publicar**: Quando estiver pronto, clique em "Publicar"

### Para Clientes

1. **Aceder ao álbum**: Vá para `/client-auth`
2. **Introduzir email**: Use o email fornecido pelo fotógrafo
3. **Visualizar fotos**: Navegue pelas fotos do evento
4. **Selecionar fotos**: Clique nas fotos que deseja comprar
5. **Finalizar compra**: Escolha o tipo de entrega e confirme

## Design System

O projeto utiliza um design system baseado no shadcn/ui com:

- **Cores**: Sistema de cores HSL com suporte a modo escuro
- **Tipografia**: Fontes do sistema com hierarquia clara
- **Componentes**: Botões, cards, inputs, dialogs reutilizáveis
- **Layout**: Grid responsivo e containers centralizados
- **Interações**: Transições suaves e estados hover/focus

## Persistência de Dados

**Nota**: Esta é uma versão demo que utiliza `localStorage` para persistir dados. Para produção, seria necessário:

- Implementar base de dados (MySQL/PostgreSQL)
- Criar modelos Eloquent
- Implementar autenticação real
- Adicionar sistema de pagamentos
- Configurar upload de ficheiros

## Desenvolvimento

### Compilar Assets
```bash
# Desenvolvimento (com hot reload)
npm run dev

# Produção
npm run build
```

### Estrutura de Actions

Cada página tem uma Action correspondente em `app/Actions/Http/`:

```php
<?php

namespace App\Actions\Http;

use Illuminate\View\View;

class ExampleAction
{
    public function __invoke(): View
    {
        return view('example');
    }
}
```

### Adicionar Novas Páginas

1. Criar Action em `app/Actions/Http/`
2. Adicionar rota em `routes/web.php`
3. Criar template Blade em `resources/views/`

## Contribuição

1. Fork o projeto
2. Crie uma branch para a sua feature
3. Commit as suas alterações
4. Push para a branch
5. Abra um Pull Request

## Licença

Este projeto está sob a licença MIT.