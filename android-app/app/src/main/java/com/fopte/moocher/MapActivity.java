package com.fopte.moocher;

import android.app.DownloadManager;
import android.content.Context;
import android.content.Intent;
import android.location.Location;
import android.location.LocationManager;
import android.os.StrictMode;
import android.support.v7.app.ActionBarActivity;
import android.os.Bundle;
import android.util.Log;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.EditText;
import android.widget.Toast;

import com.android.volley.Request;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.VolleyLog;
import com.android.volley.toolbox.JsonArrayRequest;
import com.android.volley.toolbox.JsonObjectRequest;
import com.google.android.gms.maps.GoogleMap;
import com.google.android.gms.maps.MapFragment;
import com.google.android.gms.maps.OnMapReadyCallback;
import com.google.android.gms.maps.model.LatLng;
import com.google.android.gms.maps.model.Marker;
import com.google.android.gms.maps.model.MarkerOptions;

import org.apache.http.HttpResponse;
import org.apache.http.HttpStatus;
import org.apache.http.NameValuePair;
import org.apache.http.client.ClientProtocolException;
import org.apache.http.client.HttpClient;
import org.apache.http.client.entity.UrlEncodedFormEntity;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.message.BasicNameValuePair;
import org.apache.http.util.EntityUtils;
import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.IOException;
import java.util.ArrayList;
import java.util.List;


public class MapActivity extends ActionBarActivity implements OnMapReadyCallback {

    GoogleMap myMap;
    ArrayList<Marker> markers;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_map);
        MapFragment mapFragment = (MapFragment) getFragmentManager().findFragmentById(R.id.map);
        mapFragment.getMapAsync(this);

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


        googleMap.setMyLocationEnabled(true);

        //get Lat and Long
        LocationManager lm = (LocationManager)getSystemService(Context.LOCATION_SERVICE);
        Location location = lm.getLastKnownLocation(LocationManager.GPS_PROVIDER);
        if (location != null) {

            double longitude = location.getLongitude();
            double latitude = location.getLatitude();

            markers = new ArrayList<Marker>();
            writeMarkers(googleMap, longitude, latitude);

          //  markers.add(markers.size(), googleMap.addMarker(new MarkerOptions().position(new LatLng(latitude, longitude + increment)).title("Content").snippet("Message message message")));
        }

        // STILL NEED TO ADD MARKERS FROM THE SERVER

        myMap = googleMap;
    }

    public void writeMarkers(GoogleMap googleMap, double longitude, double latitude) {

        double radius = 5000000;
        String url = "http://moocher.atwebpages.com/api/v1/nearby.php?longitude=" + longitude + "&latitude=" + latitude + "&radius=" + radius;
        String thing = getPage(url);

        try {
            JSONArray array = new JSONArray(thing);
            Log.e("JSON ARRAY STRING", array.toString());
            Log.e("JSON ARRAY SIZE", Integer.toString(array.length()));
            for (int i = 0; i < array.length(); i++) {
                Log.e("MARKER DRAWING", Integer.toString(i));
                JSONObject jsonObject = array.getJSONObject(i);
                String tag = "Marker " + i;
                String message = jsonObject.getString("additional_instructions");
                double latitudeM = jsonObject.getDouble("latitude");
                double longitudeM = jsonObject.getDouble("longitude");
                markers.add(markers.size(), googleMap.addMarker(new MarkerOptions().position(new LatLng(latitudeM, longitudeM)).title(tag).snippet(message)));
            }
        } catch (JSONException e) {
            e.printStackTrace();
        }
    }

    private String getPage(String url) {

        String str = "";

        try
        {

            int SDK_INT = android.os.Build.VERSION.SDK_INT;
            if (SDK_INT > 8)
            {
                StrictMode.ThreadPolicy policy = new StrictMode.ThreadPolicy.Builder()
                        .permitAll().build();
                StrictMode.setThreadPolicy(policy);
                //your codes here

                HttpClient hc = new DefaultHttpClient();
                HttpPost post = new HttpPost(url);

                HttpResponse rp = hc.execute(post);

                if(rp.getStatusLine().getStatusCode() == HttpStatus.SC_OK)
                {
                    str = EntityUtils.toString(rp.getEntity());
                }

            }
        }catch(IOException e){
            e.printStackTrace();
        }

        return str;
    }
}
