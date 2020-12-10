&lt;?php<br><br>
<br>
namespace App\Http\Controllers\Backend;<br>
<br>
use Illuminate\Http\Request;<br>
use App\Http\Controllers\Controller;<br>
use App\Helpers\ImageUploadHelper;<br>
use App\Helpers\QueryHelper;<br>
use App\Helpers\StringHelper;<br>
use App\Helpers\NumberHelper;<br>
use App\Models\{{ ucfirst($created) }};<br>
<br>
class {{ ucfirst($created) }}Controller extends Controller<br>
{<br><br>
    {!! $tab !!}/**<br>
    {!! $tab !!} * Site Access<br>
    {!! $tab !!}**/<br>
    {!! $tab !!}public function __construct()<br>
    {!! $tab !!}{<br>
    {!! $tab !!}{!! $tab !!}&dollar;this->middleware('auth:admin');<br>
    {!! $tab !!}}<br>

    @if($type_ == 'oneClickAll')<br>
    {!! $tab !!}public function index()<br>
    {!! $tab !!}{<br>
    {!! $tab.$tab !!}&dollar;rows = {{ ucfirst($created) }}::orderBy('status', 'desc')->orderBy('id', 'desc')->get();<br>
    {!! $tab !!}{!! $tab !!}return view('backend.pages.{{ $created }}.index', compact('rows'));<br>
    {!! $tab !!}}<br><br>

    {!! $tab !!}public function add()<br>
    {!! $tab !!}{<br>
    {!! $tab !!}{!! $tab !!}return view('backend.pages.{{ $created }}.add');<br>
    {!! $tab !!}}<br><br>

    {!! $tab !!}public function store(Request &dollar;request)<br>
    {!! $tab !!}{<br>
    {!! $tab.$tab !!}&dollar;this->validate(&dollar;request, [<br>
    {!! $tab !!}{!! $tab !!}{!! $tab !!}'' => '',<br>
    {!! $tab !!}{!! $tab !!}]);<br>
    {!! $tab.$tab !!}&dollar;data = &dollar;request->except(['_token']);<br>
    {!! $tab !!}{!! $tab !!}QueryHelper::simpleInsert('{{ ucfirst($created) }}', &dollar;data);<br>
    {!! $tab !!}{!! $tab !!}session()->flash('add_message', 'Added');<br>
    {!! $tab !!}{!! $tab !!}return redirect()->route('admin.{{ $created }}.index');<br>
    {!! $tab !!}}<br><br>

    {!! $tab !!}public function edit(&dollar;id)<br>
    {!! $tab !!}{<br>
    {!! $tab.$tab !!}&dollar;row = {{ ucfirst($created) }}::where('id', &dollar;id)->first();<br>
    {!! $tab !!}{!! $tab !!}return view('backend.pages.{{ $created }}.edit', compact('row'));<br>
    {!! $tab !!}}<br><br>

    {!! $tab !!}public function update(Request &dollar;request, &dollar;id)<br>
    {!! $tab !!}{<br>  
    {!! $tab.$tab !!}&dollar;{{ $created }} = {{ ucfirst($created) }}::where('id', &dollar;id)->first();<br>
    {!! $tab.$tab !!}&dollar;this->validate(&dollar;request, [<br>
    {!! $tab !!}{!! $tab !!}{!! $tab !!}'' => '',<br>
    {!! $tab !!}{!! $tab !!}]);<br>
    {!! $tab.$tab !!}&dollar;data = &dollar;request->except(['_token']);<br>
    {!! $tab.$tab !!}&dollar;{{ $created }}->update(&dollar;data);<br>
    {!! $tab !!}{!! $tab !!}session()->flash('update_message', 'Added');<br>
    {!! $tab !!}{!! $tab !!}return redirect()->route('admin.{{ $created }}.index');<br>
    {!! $tab !!}}<br><br>

    {!! $tab !!}public function delete(&dollar;id)<br>
    {!! $tab !!}{<br>
    {!! $tab.$tab !!}&dollar;{{ $created }} = {{ ucfirst($created) }}::where('id', &dollar;id)->first();<br>
    {!! $tab.$tab !!}&dollar;data['status'] = 0;<br>
    {!! $tab.$tab !!}&dollar;{{ $created }}->update(&dollar;data);<br>
    {!! $tab !!}{!! $tab !!}session()->flash('deactive_message', 'Deactived');<br>
    {!! $tab !!}{!! $tab !!}return redirect()->route('admin.{{ $created }}.index');<br>
    {!! $tab !!}}<br>
}<br>
@elseif($type_ == 'oneClickAllWithView')<br>
{!! $tab !!}public function index()<br>
{!! $tab !!}{<br>
{!! $tab.$tab !!}&dollar;rows = {{ ucfirst($created) }}::orderBy('status', 'desc')->orderBy('id', 'desc')->get();<br>
{!! $tab !!}{!! $tab !!}return view('backend.pages.{{ $created }}.index', compact('rows'));<br>
{!! $tab !!}}<br><br>

{!! $tab !!}public function add()<br>
{!! $tab !!}{<br>
{!! $tab !!}{!! $tab !!}return view('backend.pages.{{ $created }}.add');<br>
{!! $tab !!}}<br><br>

{!! $tab !!}public function store(Request &dollar;request)<br>
{!! $tab !!}{<br>
{!! $tab.$tab !!}&dollar;this->validate(&dollar;request, [<br>
{!! $tab !!}{!! $tab !!}{!! $tab !!}'' => '',<br>
{!! $tab !!}{!! $tab !!}]);<br>
{!! $tab.$tab !!}&dollar;data = &dollar;request->except(['_token']);<br>
{!! $tab !!}{!! $tab !!}QueryHelper::simpleInsert('{{ ucfirst($created) }}', &dollar;data);<br>
{!! $tab !!}{!! $tab !!}session()->flash('add_message', 'Added');<br>
{!! $tab !!}{!! $tab !!}return redirect()->route('admin.{{ $created }}.index');<br>
{!! $tab !!}}<br><br>

{!! $tab !!}public function view(&dollar;id)<br>
{!! $tab !!}{<br>
{!! $tab.$tab !!}&dollar;row = {{ ucfirst($created) }}::where('id', &dollar;id)->first();<br>
{!! $tab !!}{!! $tab !!}return view('backend.pages.{{ ($created) }}.view', compact('row'));<br>
{!! $tab !!}}<br><br>

{!! $tab !!}public function edit(&dollar;id)<br>
{!! $tab !!}{<br>
{!! $tab.$tab !!}&dollar;row = {{ ucfirst($created) }}::where('id', &dollar;id)->first();<br>
{!! $tab !!}{!! $tab !!}return view('backend.pages.{{ $created }}.edit', compact('row'));<br>
{!! $tab !!}}<br><br>

{!! $tab !!}public function update(Request &dollar;request, &dollar;id)<br>
{!! $tab !!}{<br>  
{!! $tab.$tab !!}&dollar;{{ $created }} = {{ ucfirst($created) }}::where('id', &dollar;id)->first();<br>
{!! $tab.$tab !!}&dollar;this->validate(&dollar;request, [<br>
{!! $tab !!}{!! $tab !!}{!! $tab !!}'' => '',<br>
{!! $tab !!}{!! $tab !!}]);<br>
{!! $tab.$tab !!}&dollar;data = &dollar;request->except(['_token']);<br>
{!! $tab.$tab !!}&dollar;{{ $created }}->update(&dollar;data);<br>
{!! $tab !!}{!! $tab !!}session()->flash('update_message', 'Added');<br>
{!! $tab !!}{!! $tab !!}return redirect()->route('admin.{{ $created }}.index');<br>
{!! $tab !!}}<br><br>

{!! $tab !!}public function delete(&dollar;id)<br>
{!! $tab !!}{<br>
{!! $tab.$tab !!}&dollar;{{ $created }} = {{ ucfirst($created) }}::where('id', &dollar;id)->first();<br>
{!! $tab.$tab !!}&dollar;data['status'] = 0;
{!! $tab.$tab !!}&dollar;{{ $created }}->update(&dollar;data);<br>
{!! $tab !!}{!! $tab !!}session()->flash('deactive_message', 'Deactived');<br>
{!! $tab !!}{!! $tab !!}return redirect()->route('admin.{{ $created }}.index');<br>
{!! $tab !!}}<br>
}<br>
@elseif($type_ == 'model')
{!! $tab !!}public function index()<br>
{!! $tab !!}{<br>
{!! $tab.$tab !!}&dollar;rows = {{ ucfirst($created) }}::orderBy('status', 'desc')->orderBy('id', 'desc')->get();<br>
{!! $tab !!}{!! $tab !!}return view('backend.pages.{{ $created }}.index', compact('rows'));<br>
{!! $tab !!}}<br><br>

{!! $tab !!}public function store(Request &dollar;request)<br>
{!! $tab !!}{<br>
{!! $tab.$tab !!}&dollar;this->validate(&dollar;request, [<br>
{!! $tab !!}{!! $tab !!}{!! $tab !!}'' => '',<br>
{!! $tab !!}{!! $tab !!}]);<br>
{!! $tab.$tab !!}&dollar;data = &dollar;request->except(['_token']);<br>
{!! $tab !!}{!! $tab !!}QueryHelper::simpleInsert('{{ ucfirst($created) }}', &dollar;data);<br>
{!! $tab !!}{!! $tab !!}session()->flash('add_message', 'Added');<br>
{!! $tab !!}{!! $tab !!}return redirect()->route('admin.{{ $created }}.index');<br>
{!! $tab !!}}<br><br>

{!! $tab !!}public function update(Request &dollar;request, &dollar;id)<br>
{!! $tab !!}{<br>  
{!! $tab.$tab !!}&dollar;{{ $created }} = {{ ucfirst($created) }}::where('id', &dollar;id)->first();<br>
{!! $tab.$tab !!}&dollar;this->validate(&dollar;request, [<br>
{!! $tab !!}{!! $tab !!}{!! $tab !!}'' => '',<br>
{!! $tab !!}{!! $tab !!}]);<br>
{!! $tab.$tab !!}&dollar;data = &dollar;request->except(['_token']);<br>
{!! $tab.$tab !!}&dollar;{{ $created }}->update(&dollar;data);<br>
{!! $tab !!}{!! $tab !!}session()->flash('update_message', 'Added');<br>
{!! $tab !!}{!! $tab !!}return redirect()->route('admin.{{ $created }}.index');<br>
{!! $tab !!}}<br><br>

{!! $tab !!}public function delete(&dollar;id)<br>
{!! $tab !!}{<br>
{!! $tab.$tab !!}&dollar;{{ $created }} = {{ ucfirst($created) }}::where('id', &dollar;id)->first();<br>
{!! $tab.$tab !!}&dollar;data['status'] = 0;<br>
{!! $tab.$tab !!}&dollar;{{ $created }}->update(&dollar;data);<br>
{!! $tab !!}{!! $tab !!}session()->flash('deactive_message', 'Deactived');<br>
{!! $tab !!}{!! $tab !!}return redirect()->route('admin.{{ $created }}.index');<br>
{!! $tab !!}}<br>
}<br>
@else
}<br>
<script type="text/javascript">
    $('.text_2-container').hide();
</script>
@endif