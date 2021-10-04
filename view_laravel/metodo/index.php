<?php 

    /**
        * Display a listing of the resource.
        *
        * @return Response
        */
    public function index()
    {
        // get all the sharks
        $sharks = shark::all();

        // load the view and pass the sharks
        return View::make('sharks.index')
            ->with('sharks', $sharks);
    }

