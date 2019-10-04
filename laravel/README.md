# AMBIENTE DE DESENVOLVIMENTO
## COMPOSER
* Instalação do composer
```
sudo apt-get install composer
```

## LARAVEL
* Instalação do laravel

link: https://laravel.com/docs/5.6#installation
```
composer global require "laravel/installer"
```

## VALET LARAVEL
* Download do valet

link: https://cpriego.github.io/valet-linux/
```
composer global require cpriego/valet-linux
```
* Inserindo o PATH para manipulação por terminal (inserir na última linha do profile)
```
nano ~/.profile
PATH="$HOME/.config/composer/vendor/bin:$PATH"
source ~/.profile
```

* Instalação do valet e dependências
```
sudo apt-get install network-manager libnss3-tools jq xsel
sudo service apache2 stop
sudo apt-get install nginx
sudo systemctl status nginx
valet install
```

## PHP 7.2 Debian
* Instalação de algumas dependências
```
sudo apt-get install apt-transport-https lsb-release ca-certificates
```

* Adição do php no sources.list
```
sudo wget -O /etc/apt/trusted.gpg.d/php.gpg https://packages.sury.org/php/apt.gpg
echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" | sudo tee /etc/apt/sources.list.d/php.list
```

* Instalação do php e dependências
```
sudo apt-get install php7.2
sudo apt-get install php7.2-cli php7.2-common php7.2-curl php7.2-gd php7.2-json php7.2-mbstring php7.2-mysql php7.2-opcache php7.2-readline php7.2-xml
php -v
```

* Other (mais completo)
```
sudo apt-get install php7.2 php7.2-mysql libapache2-mod-php7.2 php-apcu php7.2-gd php7.0-mcrypt php-memcache php7.2-curl php7.2-tidy php-xml php-json php7.2-mbstring php-gettext libmcrypt-dev mcrypt php-gd libmcrypt4 libmhash2 libtidy5 libxslt1.1 php-apcu-bc php-pear php7.2-mbstring php7.2-xml php7.2-zip
```

## COMANDOS LARAVEL
* Novo projeto
```
laravel new nomeprojeto

* If erro
Cannot create cache directory ...
execute:
sudo chown -R $USER $HOME/.composer

// configurações iniciais
php -r "file_exists('.env') || copy('.env.example', '.env');"
php artisan key:generate
php artisan package:discover
```

* Teste nos arquivo tests/ sufix: nomeTest.php
```
./vendor/bin/phpunit
```

## O LARAVEL
## Estrutura de diretórios do LARAVEL
### Pastas
* app/

É onde ficará grande parte de seu aplicativo. Modelos, controladores, definições de rota, comnados e seu código de comínio PHP entrarão aqui.

* bootstrap/

Contém os arquivos que o framework Laravel usa para a inicialização sempre que e executado.

* config/

É onde todos os arquivos de configuração residem.

* database/

É onde as migrações e seeds do banco de dados residem.

* public/

É o diretório para o qual o servidor aponta quando está servindo o site. Ele contém o arquivo index.php, que é o controlador frontal que inicia o processo de bootstrapping e roteia todas as solicitações apropriadamente. Também é o local onde entram arquivos voltados ao público, como os de imagens folhas de estilo, scripts ou downloads.

* resources/

É ondem residem arquivos não PHP que são necessários para outros scripts. Views, arquivos de idioma e (opcionalmente) arquivos Sass/LESS e de código-fonte JavaScript residem aqui.

* routes/

É onde todas as definições de rota residem, tanto para rotas HTTP quanto para "rotas de console", ou comandos do Artisan.

* storage/

É onde caches, logs e arquivos compilados do sistema residem.

* tests/

É onde residem testes de unidade e integração.

* vendor/

É onde o Composer instala suas dependências. Ele é ignorado pelo Git (marcado para ser excluído do sistema de controle de versões), já que o Composer deve ser executado como parte do processo de implantação em servidores remotos.

### Arquivos
* .env e .env.example

São os arquivos que definem as variáveis de ambiente (variáveis que são diferentes em cada ambiente e que, portanto, não são confirmadas no controle de versões). .env.example é um template que cada ambiente deve duplicar para criar seu próprio arquivo .env, que é ignorado pelo Git.

* artisan

Arquivo que permite a execução de comandos do Artisan na linha de comando.

* .gitignore e .gitattributes

São arquivos de configuração do Git.

* composer.json e composer.lock

São os arquivos de configuração do Composer; composer.json é editável pelo usuário e composer.lock não. Esses arquivos compartilham algumas informações básicas sobre esse projeto e também definem suas dependências PHP.

* gulpfile.js

É o arquivo de configuração (opcional) do Elixir e Gulp. Ele serve para a compilação e o processamento de assets frontend.

* package.json

É como composer.json, porém para assets frontend.

* phpunit.xml

É um arquivo de configuração do PHPUnit, a ferramenta que o Laravel usa para testes de uso imediato.

* readme.md

É um arquivo Markdown que fornece uma introdução básica ao laravel.

* server.php

É um servidor de backup que tenta permitir que servidores menos capazes visualizem o aplicativo laravel.

## Acessando variáveis de configuração
### Arquivo config/services.php
* Valores armazenados como array
```
// config/services.php
return [
    'sparkpost' => [
        'secret' => 'abcdefg'
    ]
];
```
* Acesso
```
config('services.sparkpost.secret')
```

### Arquivo .env
Útil para armazenar valores que são diferentes para cada ambiente. (.env é ignorado pelo git)
* Acesso
```
env('BUGSNAG_API_KEY')
```

## Roteamento e controladores
### Rota
Rotas da web (routes/web.php); Rotas de API (routes/api.php)

* Rota básica (closure == funções anônimas)
```
// routes/web.php (cl)
Route::get('/', function() {
    return 'Hello, world';
});

Route::get('about', function() {
    return view('about');
});
```

* Verbos mais comuns para rotas: get, post, put, delete, patch.
```
// routes/web.php (cl)
Route::get('/', function() {});
Route::post('/', function() {});
Route::put('/', function() {});
Route::delete('/', function() {});
Route::any('/', function() {});
Route::match(['get', 'post'], '/', function() {});
```

* Rotas chamando controladores

Acessando o método index do controlador WelcomeController
```
Route::get('/', 'WelcomeController@index');
```

* Parâmetros de rota
```
Route::get('users/{id}/friends', function($id) {
    //
});
```

* Parâmetros de rota opcionais
```
Route::get('users/{id?}', function($id = 'fallbackId') {
    //
});
```

* Rotas com regexes
```
Route::get('users/{id}', function($id) {
    //
})->where('id', '[0-9]+');

Route::get('users/{id}/{slug}', function($id, $slug) {
    //
})->where(['id' => '[0-9]+', 'slug' => '[A-Za-z]+']);
```

* Helper url
```
<?php echo url('/'); ?>
```

* Nomes de rotas
```
Route::get('users/{id}', 'MembersController@show')->name('members.show');
<?php echo route('members.show', ['id' => 14]); ?>

route('members.show', ['id' => 14, 'opt' => 'a']);
// http://myapp.com/users/14?opt=a
```

* Grupos de rotas

Utilizado para compartilhar características (requisito de autenticação, prefixo, caminho, namespace)
```
// ['middleware' => 'auth'];
// ['prefix' => 'api'] // /api
// ['domain' => 'api.myapp.com']
// ['namespace' => 'API']
Route::group([], function () {
    Route::get('hello', function() {
        return 'Hello';
    });
    Route::get('world', function() {
        return 'World';
    });
});
```

* Subdomínio parametrizado
```
Route::group(['domain' => '{account}.myapp.com'], function () {
    Route::get('/', function($account) {
        //
    });
    Route::get('users/{id}', function($account, $id) {
        //
    });
});
```

* Prefixos de nome para grupos de rotas
```
Route::group(['as' => 'users.', 'prefix' => 'users'], function () {
    Route::group(['as' => 'comments.', 'prefix' => 'comments'], function () {
        // users.comments.show
        Route::get('{id}', function($id) {
            //
        })->name('show');
    });
});
```

## Views
```
Route::group('/', function () {
    return view('home');
});

// reources/views/tasks/index[.blade].php
Route::group('tasks', function () {
    return view('tasks.index')
        ->with('tasks', Task::all());
});

// Compartilhar variáveis com todos os templates
view()->share('variableName', 'variableValue');
```

## Controlador
* Criação
```
php artisan make:controller TasksController
```

* Criação c/Rotas de recurso básicas
```
php artisan make:controller TasksController --resource
```

* Entradas no usuário
```
// Facade Input
public function store() {
    $task = new Task;
    $task->title = Input::get('title');
    $task->description = Input::get('description');
    $task->save();

    return redirect('tasks');
}

// Objeto Request
public function store(Request $request) {
    $task = new Task;
    $task->title = $request->input('title');
    $task->description = $request->input('description');
    $task->save();

    return redirect('tasks');
}
```

* Métodos dos controladores de recursos do laravel
```
                                Método de
Verbo       URL                 Controlador     Nome            Descrição
GET         tasks               index()         tasks.index     Exibi todas tarefas
GET         tasks/create        create()        tasks.create    Exibi o form da tarefa create
POST        tasks               store()         tasks.store     Aceita o envio do form da tarefa create
GET         tasks/{task}        show()          tasks.show      Exibi uma única tarefa
GET         tasks/{task}/edit   edit()          tasks.edit      Edita uma única tarefa
PUT/PATCH   tasks/{task}        update()        tasks.update    Aceita o envio do form da tarefa edit
DELETE      tasks/{task}        destroy()       tasks.destroy   Exclui uma única tarefa
```

* Verificar rotas que a aplicação possui
```
php artisan route:list
```

## Vinculação rota modelo

* Rota modelo
```
Route::get('conferences/{id}', function ($id) {
    $conference = Conference::findOrFail($id);
});
```

* Vinculação Implícita

Ocorre com a nomeação do parâmetro de rota igual ao modelo e então submeter o parâmetro a typehinting no closure/metodo do controlador
```
Route::get('conferences/{conference}', function (Conference $conference) {
    return view('conferences.show')->with('conference', $conference);
});
```

* Vinculação rota modelo personalizada

Adição de linha ao método boot() (App/Providers/RouteServiceProvider)
```
$router->model('event', Conference::class);
// Sempre que uma rota tiver um parâmetro chamado {event}, o resolvedor de rota retornará uma instância da classe Conference com o ID desse parâmetro de URL.

Route::get('events/{event}', function (Conference $event) {
    return view('events.show')->with('event', $event);
});
```

* Cache de rota

Acelera o processo de rotas.
```
// Criação
php artisan route:cache

// Exclusão
php artisan route:clear
```

## Spoofing de método de formulário

* Necessário para métodos diferentes de post e get
```
<form action="" methos="POST">
    <input type="hidden" name="_method" value="PUT/PATCH/DELETE">
</form>
```

* Proteção contra CSRF

Proteção contra ataque de falsificação entre sites, exigindo um token de atutenticação
```
// Adição de campos no form
<?php echo csrf_field(); ?>
// ou
<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
```

## Redirecionamentos

* redirect()->to()
```
Route::(...) {
    // redirect()->to('login');
    // redirect('login');
    // Redirect::to('login');
});
```

* redirect()->route()
```
// s/parâmetros
redirect()->route('conferences.index');

// c/parâmetros
redirect()->route('conferences.show', ['conference' => 99]);
```

* redirect()->back()

Redireciona o usuário para página de onde ele veio.
```
redirect()->();
redirect()->back();
```

* Outros redirecionamento
```
redirect()
->home();       // redireciona para uma rota chamada home
->refresh();    // redireciona para a mesma página que o usuário está atualmente
->away();       // permite o redirecionamento para um URL externo sem a validação padrão de URL
->secure();     // é como to() com o parâmetro secure configurado como true
->action();     // permite a vinculação a um controlado e a um método como: action('MyController@myMethod').
->guest();      // (usado internamente pelo sistema de autenticação) quando o usuário visita uma rota para o qual não foi autenticado, esse método captura a rota "pretendida" e redireciona o usuário (em geral para uma página de login).
->intended();   // (usado internamente pelo sistema de autenticação) após uma autenticação bem-sucedida, ele captura o URL "pretendido" armazenado pelo método guest() e redireciona o usuário para esse local.
```

* redirect()->with()
```
redirect('dashboard')->with('erro', true);
redirect('dashboard')->with(['erro' => true, 'message' => 'Whoops']);
```

* Redirecionamento com entrada de formulário
```
Route::get('form', function(){
    return view('form');
});

// Retorna para o formulário com os dados inseridos pelo usuário
(...)
redirect('form')
    ->withInput()
    ->with(['erro' => true, 'message' => 'Whoops']);
(...)

// Obtém os dados com Helper old()
old() // retorna todos
old('username', 'Default username instructions here');
```

* Redirecionamento com erros
```
Route::post('form', function() {
    $validator = Validator::make($request->all(), $this->validationRules);

    if ($validator->fails()) {
        return redirect('form')
            ->withErrors($validator)
            ->withInput();
    }
});
```

* Abortando a solicitação
```
Route::post('', function(Illuminate\Http\Request) {
    abort(403, 'ou cannot do that');
    abort_unless($request->has('magicToken'), 403);
    abort_if($request->user()->isBanned, 403);
});
```

* Respostas personalizadas
```
response()->make('Hello, World');
response()->json(User::all());
response()->download('file501751.pdf', 'myFile.pdf'); // realiza o download
response()->file('file501751.pdf', 'myFile.pdf'); // exibi no navegador
```

* Testando

## Blade
* Ecoando dados
```
{{ $dado }}     // ecoa com htmlentities()
{!! $dado !!}   // sem htmlentities
@{{}}           // exibindo {{}}
```

* Estruturas de controle
```
// Condicionais
@if
@elseif
@else
@endif

// Oposto do if (!$valor)
@unless
@endunless

// Loop
@for        @endfor
@foreach    @endforeach
@while      @endwhile
@forelse    @empty      @endforelse

// Variável $loop existe implicitamente em @foreach e @forelse
index       // Índice de base - do item atual no loop
interation  // Índice de base 1 do item atual no loop
remaining   // Quantos itens permanecem no loop
count       // Contagem dos itens do loop
first       // Booleano indicando se esse é o primeiro item do loop
last        // Booleano indicando se esse é o último item do loop
depth       // Quantos "níveis" há nesse loop
parent      // Referência a variável $loop do item do loop-pai
```

* Verificando se a variável está definida
```
{{ $variavel or "Default"}}
```

* Layout Blade
```
// Master (layouts/master.blade.php)
@yield('title', 'Home Page')
@yield('content')
@section('footerScripts')
    (...)
@show

// Estendendo
@extends('layouts.master')
@section('title', 'Dashboard')
@section('content')
    (...)
@endsection
@section('footerScripts')
    @parent
    (...)
@endsection

// Incluindo view partials
@include('sign-up-button', ['text' => 'See just how great it is'])

// Loop de inclusão
// $modules é o conjunto; modules é o nome da variável; empty-module view exibida caso conjunto esteja vazio
@each('partials.module', $modules, 'modules', 'partials.empty-module')
```

* View composers
```
// Compartilhar variável globalmente (Provedor de serviço App\Providers\[AppServiceProvider])
public funciton boot() {
    ...
    view()->share('posts', Post::recent());
}

// Baseado em closure
// única view
view()->composer('partials.sidebar', function ($view) {
    $view->with('posts', Post::recent());
});

// várias views
view()->composer(
    ['partials.header', 'partials.footer'],
    function () {
        $view->with('posts', Post::recent());
    }
);
// Todas view do diretório partials/
view()->composer('partials.*', function () {
    $view->with('posts', Post::recent());
});

// Baseado em classes (mais flexível, mais complexo)
// recomendação: App\Http\ViewComposers\[RecentPostsComposer]
<?php

namespace App\Http\ViewComposers;

use App\Post;
use Illuminate\Contracts\View\View;

Class RecentPostsComposer {

    // Opção 1
    private $posts;

    public function __construct(Post $posts) {
        $this->posts = $posts;
    }

    public function compose(View $view) {
        $view->with('posts', $this->posts->recent());
    }

    // Opção 2
    public function compose(View $view) {
        $view->with('posts', Post::recent());
    }

}

// Registrando o view composer em [AppServiceProvider]
public function boot() {
    ...
    view()->composer(
        'partials.sidebar',
        \App\Http\ViewComposers\RecentPostsComposer::class
    );
}
```

* Injeção de serviços do Blade
```
// É possível injetar igualmente os views composers
// Injeção por meio do construtor de definição da rota
Route::get('backend/sales', function (AnalyticsService $analytics) {
    return view('backend.sales-graphs')
        ->with('analytics', $analytics);
})

// Conteúdo da view
<div class="finances-display">
    {{ $analytics->getBalance() }} / {{ $analytics->getBudget() }}
</div>

// Injeção direta em uma View
@inject('analytics', 'App\Services\Analytics')

<div class="finances-display">
    {{ $analytics->getBalance() }} / {{ $analytics->getBudget() }}
</div>
```

* Diretivas personalizadas do Blade
```
// Útil registrar em um provedor de serviço
// Criando a diretiva @ifGuest
public function boot() {
    Blade::directive('ifGuest', function () {
        return "<?php if (auth()->guest()): ?>";
    });
}

// Parâmetros em diretivas
// vinculando
Blade::directive('newLinesToBr', function ($expression) {
    return "<?php echo nl2br({$expression}); ?>";
});

// Em uso
<p>@newLinesToBr($message->body)</p>

/* Diretivas para aplicativo multitenant
 * - Usuários pudessem visitar o site por: myapp.com; client1.myapp.com; (...)
 * - Ex. Classe Context para implementar a lógica multitenant
 * - app('context') = atalho para obtenção de uma instância da classe
 * - Exemplo captura informações e a lógica do contexto da visita atual,
 * verifica quem é o usuário e se está visitando um site público ou Subdomínio
 */
@if (app('context')->isPublic())
    &copy; Copyright MyApp LLC
@else
    &copy; Cpyright {{ app('context')->client->name }}
@endif

// Possível simplificar "if (app('content')->isPublic)" para diretiva @ifPublic
```

* Testando

## Componentes frontend

### Mix
Editar arquivo webpack adicionando a linha:
```
mix.styles([
    'public/css/vendor/normalize.css',
    'public/css/vendor/videojs.css'
    ], 'public/css/all.css');
```

Gera o arquivo all.css em public após o comando:
```
npm run dev
```

### Paginação
* Método paginate(), implementado em todos modelos do eloquent
```
/* PAGINADOR AUTOMATICO */
// exemplo em controlador
return view('posts.index', ['posts' => DB::table('posts')->paginate(20)]);
// 20 = quantidade de conteúdo por página

//exemplo na view
@foreach ($posts as $post)
	<tr><td>{{ $post->title }}</td></tr>
@endforeach

{{ $post->links() }}
// links() exibi o controle de paginação c/ bootstrap

/* Paginadores manuais */
[pg 111] do livro texto

```

### Erros
* Todas views possuem a variável $erros
```
// Criando mensagens
$mesages = [
	'errors' => [
		'Something went wrong with edit 1!'
	],
	'messages' => [
		'Edit 2 was successful.'
	]
];
$messagebag = new \Illuminate\Support\MessageBag($messages);

// Procura erros/ se houver algum, decora e ecoa
if ($messagebag->has('errors')) {
	echo '<ul id="errors">';
	foreach ($messagebag->get('errors', '<li><b>:message</b></li>') as $error) {
		echo $error;
	}
	echo '</ul>';
}

redirect('route')->withErrors($messagebag)

@if ($erros->any())
	...
	@foreach ($errors as $error)
		{{ $error }}
	@end...
@endif

// Dois forms em um unico view, como diferenciar os erros?
->withErrors($validator, 'login') // enviando
$errors->login...		  // lendo [->any() or ->count()]
```

### Helpers de strings e pluralização
e === html_entities
starts_with, ends_with, str_contains (1, 2) === verifica se 1 começa, termina ou contém 2
str_is (1,2) === verifica se 2 coincide com 1 (p.ex foo* = foobar, foobaz)
str_slug === converte uma string em slug tipo URL com hifens
str_plural, str_singular === plralizam ou singularizam palavras em inglês

### Localização
```
// Definindo a localização
App::setLocale($localeName) // inserir em boot() de AppServiceProvider
//localidade de fallback em config/app.php

// Obtendo uma tradução
trans($key)
// caso não consiga pelo locale, usará o fallbak

// ex domain https://app/es/
// ex blade
{{ trans('navigation.back') }}
@lang('navigation.back')

// resource/lang/es/navigation.php
return [
	'back' => 'volver al panel'
];

// com parametros
return [
	'back' => 'Back to :section dashboard'
];
{{ trans('nagivation.back', ['section' => 'contacts']) }}

// pluralização
// resources/lang/es/messages.php
return [
	'task-deletion' => 'You have deleted a taks|You have successfully deleted tasks'
];
@if ($numTasksDeleted > 0)
	{{ trans_choice('messages.task-deletion', $numTasksDeleted) }}
@endif

// Usando o componente Translation do Symfony
return [
	'task-deletion' => "{0} You didn't manage to deete any tasks.|" .
		"[1,4] You deleted a few tasks.|" .
		"[5,Inf] You deleted a whole ton of tasks."
];
```

### Elixir
Diretório com os assets: resources/assets/[sass,less,js]

Diretório com as exportações: public/[js,css]

* Alteração da estrutura básica
```
Alterar os caminhos no objeto elixir.config
```
