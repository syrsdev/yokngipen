 <div class="justify-content-center d-flex" style="gap: .5rem;">
     @if ($show)
         <a href="{{ route($route . '.show', $id) }}" class="btn btn-info">Detail</a>
     @endif
     @if ($edit)
         <a href="{{ route($route . '.edit', $id) }}" class="btn btn-warning">Edit</a>
     @endif
     @if ($delete)
         <a href="{{ route($route . '.destroy', $id) }}" class="btn btn-danger" data-confirm-delete="true">Hapus</a>
     @endif
 </div>
