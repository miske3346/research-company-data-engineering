@foreach($villes as $ville)
<option value="{{ $ville->id }}">{{$r7b}} {{ $ville->nom }}</option>
 @if(count($ville->childs))
 @php $newR7b = $r7b . '-' @endphp 
 @include('villes-partial',['villes' => $ville->childs,'r7b'=>$newR7b])
 @endif
@endforeach