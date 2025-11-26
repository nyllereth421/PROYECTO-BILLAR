<?php

namespace App\Http\Composers;

use Illuminate\View\View;

class SweetAlertComposer
{
    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        // Compartir datos de SweetAlert con todas las vistas AdminLTE
        $view->with([
            'hasSweetAlert' => session()->has('swal_type') && session()->has('swal_message'),
            'sweetAlertType' => session('swal_type'),
            'sweetAlertMessage' => session('swal_message'),
        ]);
    }
}
