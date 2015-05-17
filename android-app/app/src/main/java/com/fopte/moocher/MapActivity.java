package com.fopte.moocher;

import android.content.Context;
import android.content.Intent;
import android.location.Location;
import android.location.LocationManager;
import android.support.v7.app.ActionBarActivity;
import android.os.Bundle;
import android.util.Log;
import android.view.Menu;
import android.view.MenuItem;
import android.widget.EditText;

import com.google.android.gms.maps.GoogleMap;
import com.google.android.gms.maps.MapFragment;
import com.google.android.gms.maps.OnMapReadyCallback;
import com.google.android.gms.maps.model.LatLng;
import com.google.android.gms.maps.model.Marker;
import com.google.android.gms.maps.model.MarkerOptions;

import java.util.ArrayList;


public class MapActivity extends ActionBarActivity implements OnMapReadyCallback {

    GoogleMap myMap;
    ArrayList<Marker> markers;
    double increment;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_map);
        MapFragment mapFragment = (MapFragment) getFragmentManager().findFragmentById(R.id.map);
        mapFragment.getMapAsync(this);
        increment = 0;

    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.menu_map, menu);
        return true;
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        // Handle action bar item clicks here. The action bar will
        // automatically handle clicks on the Home/Up button, so long
        // as you specify a parent activity in AndroidManifest.xml.

        switch (item.getItemId()) {
            case R.id.action_create_event:
                createEventActivity();
                break;
            default:
                break;
        }

        return true;
    }

    @Override
    public void onResume() {
        super.onResume();
        if (myMap != null) {
            createMap(myMap);
        }
    }

    public void createEventActivity() {
        Intent intent = new Intent(this, CreateEventActivity.class);
        //get Lat and Long
        LocationManager lm = (LocationManager)getSystemService(Context.LOCATION_SERVICE);
        Location location = lm.getLastKnownLocation(LocationManager.GPS_PROVIDER);
        double longitude = location.getLongitude();
        double latitude = location.getLatitude();
        intent.putExtra("longitude", longitude);
        intent.putExtra("latitude", latitude);
        startActivity(intent);
    }

    @Override
    public void onMapReady(GoogleMap googleMap) {
        createMap(googleMap);
    }

    public void createMap(GoogleMap googleMap) {

        Log.e("HEY", "createMap is starting");

        if (markers != null) {
            Log.e("HEY", "createMap in the markers if");
            while (markers.size() > 0) {
                Log.e("HEY", "createMap deleting a marker");
                Marker marker = markers.remove(0);
                marker.remove();
            }
            markers = null;
        } else {
            Log.e("HEY", "createMap NOT in the markers if");
        }

        increment += .001;
        Log.e("HEY", "createMap increment equals " + increment);

        googleMap.setMyLocationEnabled(true);

        //get Lat and Long
        LocationManager lm = (LocationManager)getSystemService(Context.LOCATION_SERVICE);
        Location location = lm.getLastKnownLocation(LocationManager.GPS_PROVIDER);
        if (location != null) {

            double longitude = location.getLongitude();
            double latitude = location.getLatitude();

            markers = new ArrayList<Marker>();
            markers.add(markers.size(), googleMap.addMarker(new MarkerOptions().position(new LatLng(latitude, longitude + increment)).title("Content").snippet("Message message message")));
        }

        // STILL NEED TO ADD MARKERS FROM THE SERVER

        myMap = googleMap;
    }
}
