<ul>
    @foreach ($childs as $child)
        <li>
            <a class="btn" href="#" data-toggle="modal" OnClick="acconcepts({{ $child->id }});"
                data-target="#acconceptsUpdate" title="Actualizar"> {!! $child->order !!} {{ $child->name }}
                @if (count($child->childs))
                    @include('parameters::acconcepts.manageChild', ['childs' => $child->childs])
                @endif
            </a>
        </li>
    @endforeach
</ul>
