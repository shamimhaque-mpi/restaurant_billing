{!! $tab !!}/**<br>
{!! $tab !!}* <strong>{{ $created }}</strong><br>
{!! $tab !!}**/<br>
@if($type_ == 'oneClickAll')
{!! $tab !!}Route::group(['prefix' => '{{ $created }}'], function(){<br>
{!! $tab.$tab !!}Route::get('/', 'Backend\{{ ucfirst($created) }}Controller&commat;index')->name('admin.{{ $created }}.index');<br>
{!! $tab.$tab !!}Route::get('/add', 'Backend\{{ ucfirst($created) }}Controller&commat;add')->name('admin.{{ $created }}.add');<br>
{!! $tab.$tab !!}Route::post('/add', 'Backend\{{ ucfirst($created) }}Controller&commat;store')->name('admin.{{ $created }}.store');<br>
{!! $tab.$tab !!}Route::get('/edit/{id}', 'Backend\{{ ucfirst($created) }}Controller&commat;edit')->name('admin.{{ $created }}.edit');<br>
{!! $tab.$tab !!}Route::post('/edit/{id}', 'Backend\{{ ucfirst($created) }}Controller&commat;update')->name('admin.{{ $created }}.update');<br>
{!! $tab.$tab !!}Route::get('/delete/{id}', 'Backend\{{ ucfirst($created) }}Controller&commat;delete')->name('admin.{{ $created }}.delete');<br>
{!! $tab !!}});<br>

@elseif($type_ == 'oneClickAllWithView')
{!! $tab !!}Route::group(['prefix' => '{{ $created }}'], function(){<br>
{!! $tab.$tab !!}Route::get('/', 'Backend\{{ ucfirst($created) }}Controller&commat;index')->name('admin.{{ $created }}.index');<br>
{!! $tab.$tab !!}Route::get('/add', 'Backend\{{ ucfirst($created) }}Controller&commat;add')->name('admin.{{ $created }}.add');<br>
{!! $tab.$tab !!}Route::post('/add', 'Backend\{{ ucfirst($created) }}Controller&commat;store')->name('admin.{{ $created }}.store');<br>
{!! $tab.$tab !!}Route::get('/view/{id}', 'Backend\{{ ucfirst($created) }}Controller&commat;view')->name('admin.{{ $created }}.view');<br>
{!! $tab.$tab !!}Route::get('/edit/{id}', 'Backend\{{ ucfirst($created) }}Controller&commat;edit')->name('admin.{{ $created }}.edit');<br>
{!! $tab.$tab !!}Route::post('/edit/{id}', 'Backend\{{ ucfirst($created) }}Controller&commat;update')->name('admin.{{ $created }}.update');<br>
{!! $tab.$tab !!}Route::get('/delete/{id}', 'Backend\{{ ucfirst($created) }}Controller&commat;delete')->name('admin.{{ $created }}.delete');<br>
{!! $tab !!}});<br>

@elseif($type_ == 'model')
{!! $tab !!}Route::group(['prefix' => '{{ $created }}'], function(){<br>
{!! $tab.$tab !!}Route::get('/', 'Backend\{{ ucfirst($created) }}Controller&commat;index')->name('admin.{{ $created }}.index');<br>
{!! $tab.$tab !!}Route::post('/add', 'Backend\{{ ucfirst($created) }}Controller&commat;store')->name('admin.{{ $created }}.store');<br>
{!! $tab.$tab !!}Route::post('/edit/{id}', 'Backend\{{ ucfirst($created) }}Controller&commat;update')->name('admin.{{ $created }}.update');<br>
{!! $tab.$tab !!}Route::get('/delete/{id}', 'Backend\{{ ucfirst($created) }}Controller&commat;delete')->name('admin.{{ $created }}.delete');<br>
{!! $tab !!}});<br>


@else
{!! $tab !!}Route::group(['prefix' => '{{ $created }}'], function(){<br>
{!! $tab.$tab !!}Route::get('/<strong>{{ $created }}</strong>{{ $type_ == 'index' ? '' : '/'.$type_ }}', 'Backend\{{ ucfirst($created) }}Controller&commat;{{ $type_ }}')->name('admin.<strong>{{ $created }}</strong>.{{ $type_ }}');<br>
{!! $tab !!}});<br>

@endif