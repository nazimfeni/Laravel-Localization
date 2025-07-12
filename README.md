## Setup Laravel

```
composer create-project laravel/laravel laravel-Localization
cd laravel-Localization
composer require laravel/breeze --dev
php artisan breeze:install blade
npm install && npm run dev
php artisan migrate
php artisan serve
php artisan lang:publish
```



php artisan make:middleware Localization

now update the code in Localization middleware
```
 public function handle(Request $request, Closure $next): Response
    {

        app()->setLocale(session('localization', config('app.locale')));

        return $next($request);
    }
```



and register it in bootstrap/app.php

```
 ->withMiddleware(function (Middleware $middleware): void {
        // Register Localization middleware as global
        $middleware->append(\App\Http\Middleware\Localization::class);
    })
````

## Update the below code in navigation.blade.php file
```
<x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ 'Locale' }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">

                      @foreach (config('localization.locales') as $locale)

                        <x-dropdown-link :href="route('localization', $locale)">
                            {{ __($locale) }}
                        </x-dropdown-link>

                    @endforeach

                    </x-slot>
                </x-dropdown>
```

Now create file under config folder  name localization.php and update the below code
```
<?php

return [
    'locales' => [
        'en',
        'es' 
    ]
  ];
```

php artisan make:controller LocalizationController --invokable

and update the below code
```
class LocalizationController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke($locale)
    {
        if (! in_array($locale, ['en', 'es'])) {
        abort(400);
    }

    App::setLocale($locale, config('localization.locales'));
     session(['localization' =>$locale]);

     return redirect()->back();
    }


}
```

## create necessary folder of languages under lang folder and call them from blade to translate acordingly

example:
```
  <x-input-label for="name" :value="__('auth.register.name')" />
  ```
here auth is file name under every language, register is the array name and name is the text value
## update in routes/web.php

```
route::get('/localization/{locale}', LocalizationController::class)->name('localization'); 

route::middleware(Localization::class)
->group(function(){
                // Route::get('/', function () {
                //     return view('welcome');
                // });

                Route::view('/','welcome');

                Route::get('/dashboard', function () {
                    return view('dashboard');
                })->middleware(['auth', 'verified'])->name('dashboard');

                Route::middleware('auth')->group(function () {
                    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
                    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
                    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
                });


                require __DIR__.'/auth.php';
});

```

Here all routes under localization middleware as group 

ref: https://www.youtube.com/watch?v=vpmVE1hOBow&t=26s
