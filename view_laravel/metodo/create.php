<?php 

    /**
        * Show the form for creating a new resource.
        *
        * @return Response
        */
    public function create()
    {
        // load the create form (app/views/sharks/create.blade.php)
        return View::make('sharks.create');
    }

    