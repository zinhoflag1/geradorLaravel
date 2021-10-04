<?php 
/**
        * Show the form for editing the specified resource.
        *
        * @param  int  $id
        * @return Response
        */
    public function edit($id)
    {
        // get the shark
        $shark = shark::find($id);

        // show the edit form and pass the shark
        return View::make('sharks.edit')
            ->with('shark', $shark);
    }