<?php 
/**
        * Display the specified resource.
        *
        * @param  int  $id
        * @return Response
        */
    public function show($id)
    {
        // get the shark
        $shark = shark::find($id);

        // show the view and pass the shark to it
        return View::make('sharks.show')
            ->with('shark', $shark);
    }