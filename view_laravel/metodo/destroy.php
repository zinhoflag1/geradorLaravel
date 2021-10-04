<?php
    

/**
* Remove the specified resource from storage.
*
* @param  int  $id
* @return Response
*/
    public function destroy($id)
    {
        // delete
        $shark = shark::find($id);
        $shark->delete();

        // redirect
        Session::flash('message', 'Successfully deleted the shark!');
        return Redirect::to('sharks');
    }