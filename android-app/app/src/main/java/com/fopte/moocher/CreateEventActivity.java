package com.fopte.moocher;

import android.content.Context;
import android.content.Intent;
import android.location.Location;
import android.location.LocationManager;
import android.support.v7.app.ActionBarActivity;
import android.os.Bundle;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.EditText;


public class CreateEventActivity extends ActionBarActivity {

   // double latitude;
    //double longitude;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_create_event);

       // Bundle extras = getIntent().getExtras();
        //latitude = extras.getDouble("latitude");
       // longitude = extras.getDouble("longitude");

        // if (savedInstanceState == null) {
        //    Bundle extras = getIntent().getExtras();
       //     if(extras == null) {
       //         newString= null;
       //     } else {
       //         newString = extras.getString("STRING_I_NEED");
        //    }
        //} else {
        //    newString= (String) savedInstanceState.getSerializable("STRING_I_NEED");
        //}
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.menu_create_event, menu);
        return true;
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        // Handle action bar item clicks here. The action bar will
        // automatically handle clicks on the Home/Up button, so long
        // as you specify a parent activity in AndroidManifest.xml.

        switch (item.getItemId()) {
            default:
                break;
        }

        return true;
    }


    // method called when create button is pressed
    public void create(View view) {

        //get Lat and Long
        LocationManager lm = (LocationManager)getSystemService(Context.LOCATION_SERVICE);
        Location location = lm.getLastKnownLocation(LocationManager.GPS_PROVIDER);
        double longitude = location.getLongitude();
        double latitude = location.getLatitude();
        EditText contentText = (EditText) findViewById(R.id.Content);
        String content = contentText.getText().toString();
        EditText messageText = (EditText) findViewById(R.id.Message);
        String message = messageText.getText().toString();

        // SEND TO SERVER

        onBackPressed();
    }
}
