package com.fopte.moocher;

import android.content.Context;
import android.content.Intent;
import android.location.Location;
import android.location.LocationManager;
import android.os.AsyncTask;
import android.support.v7.app.ActionBarActivity;
import android.os.Bundle;
import android.util.Log;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.EditText;

import org.apache.http.HttpEntity;
import org.apache.http.HttpResponse;
import org.apache.http.NameValuePair;
import org.apache.http.client.ClientProtocolException;
import org.apache.http.client.HttpClient;
import org.apache.http.client.entity.UrlEncodedFormEntity;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.message.BasicNameValuePair;
import org.apache.http.util.EntityUtils;

import java.io.IOException;
import java.util.ArrayList;


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
        Log.e("HEY", "longitude " + longitude);
        Log.e("HEY", "latitude " + latitude);
        EditText contentText = (EditText) findViewById(R.id.Content);
        String content = contentText.getText().toString();
        EditText messageText = (EditText) findViewById(R.id.Message);
        String message = messageText.getText().toString();

        // SEND TO SERVER
        // postData("usernameString", "passwordString", latitude, longitude, 60, content, message);

        onBackPressed();
    }

    public void postData(String username, String password, double latitude, double longitude, int lifespan, String tags, String additional_instructions) {
        // Create a new HttpClient and Post Header
        Log.e("HEY", "postData called");
        HttpClient httpclient = new DefaultHttpClient();
        HttpPost httppost = new HttpPost("http://moocher.atwebpages.com/addlocation.php");  //?username=" + username + "&password=" + password + "&longitude=" + longitude + "&latitude=" + latitude + "&lifespan=" + lifespan + "&tags=" + tags + "&additional_instructions=" + additional_instructions);



        try {
            // Add your data
            ArrayList<NameValuePair> nameValuePairs = new ArrayList<NameValuePair>();
            nameValuePairs.add(new BasicNameValuePair("username", username));
            nameValuePairs.add(new BasicNameValuePair("password", password));
            nameValuePairs.add(new BasicNameValuePair("longitude", Double.toString(longitude)));
            nameValuePairs.add(new BasicNameValuePair("latitude", Double.toString(latitude)));
            nameValuePairs.add(new BasicNameValuePair("lifespan", Integer.toString(lifespan)));
            nameValuePairs.add(new BasicNameValuePair("tags", tags));
            nameValuePairs.add(new BasicNameValuePair("additional_instructions", additional_instructions));
            httppost.setEntity(new UrlEncodedFormEntity(nameValuePairs));

            // Execute HTTP Post Request
            HttpResponse response = httpclient.execute(httppost);
            Log.e("RESPONSE", response.getEntity().toString());

        } catch (ClientProtocolException e) {
            Log.e("FAILED", "FAILED 1");
            // TODO Auto-generated catch block
        } catch (IOException e) {
            // TODO Auto-generated catch block
            Log.e("FAILED", "FAILED 2");
        }
    }
}
