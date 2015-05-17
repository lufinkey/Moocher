//
//  ViewController.swift
//  FreeFood
//
//  Created by Adam Loeb on 5/16/15.
//  Copyright (c) 2015 Fopte. All rights reserved.
//

import UIKit
import MapKit

class ViewController: UIViewController, MKMapViewDelegate, CLLocationManagerDelegate {

    @IBOutlet weak var map: MKMapView!
    
    var manager:CLLocationManager!
    var long = -84.5155;
    var lat = 39.132;
    var rad = 3000;
    
    override func viewDidLoad() {
        super.viewDidLoad()
        
        manager = CLLocationManager()
        manager.delegate = self
        manager.desiredAccuracy = kCLLocationAccuracyBest
        manager.requestAlwaysAuthorization()
        manager.startUpdatingLocation()
        manager.startMonitoringSignificantLocationChanges()
        
        map.mapType = MKMapType.Satellite
        map.showsUserLocation = true
        
        //var latitude:CLLocationDegrees = 39.132
        //var longitude:CLLocationDegrees = -84.5155
        //var latDelta:CLLocationDegrees = 0.01
        //var longDelta:CLLocationDegrees = 0.01
        //var theSpan:MKCoordinateSpan = MKCoordinateSpanMake(latDelta, longDelta)
        //var theLoc:CLLocationCoordinate2D = CLLocationCoordinate2DMake(latitude, longitude)
        //var theRegion:MKCoordinateRegion = MKCoordinateRegionMake(theLoc, theSpan)
        
        //self.map.setRegion(theRegion, animated: true)
    }

    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
        // Dispose of any resources that can be recreated.
    }
    

    func locationManager(manager:CLLocationManager, didUpdateLocations locations:[AnyObject]) {
        let spanX = 0.01
        let spanY = 0.01
        lat = map.userLocation.coordinate.latitude
        if lat == 0 { return }
        long = map.userLocation.coordinate.longitude
        var newRegion = MKCoordinateRegion(center: map.userLocation.coordinate, span: MKCoordinateSpanMake(spanX, spanY))
        map.setRegion(newRegion, animated: true)
        
        
        // See if we need to notify the user (for if we are updating in the background
        
        /*
        let url = NSURL(string: "http://local.moocher.com/api/v1/nearby.php?longitude=\(long)&latitude=\(lat)&radius=\(rad)")
        let session = NSURLSession.sharedSession()
        let dataTask = session.dataTaskWithURL(url!, completionHandler: { (data: NSData!, response:NSURLResponse!, error:NSError!) -> Void in
            //do something
            if let json: NSArray = NSJSONSerialization.JSONObjectWithData(data, options: NSJSONReadingOptions.MutableContainers, error: nil) as? NSArray {//NSDictionary {
                if json.count > 0 {
                    var localNotification: UILocalNotification = UILocalNotification()
                    localNotification.alertAction = "Testing notifications on iOS8"
                    localNotification.alertBody = "There is free stuff in your area!"
                    localNotification.fireDate = NSDate(timeIntervalSinceNow: 1)
                    UIApplication.sharedApplication().scheduleLocalNotification(localNotification)
                }
            }
        })*/
    }
    
    override func viewWillAppear(animated: Bool) {
        
        // get data and set up pins on the screen
        let url = NSURL(string: "http://local.moocher.com/api/v1/nearby.php?longitude=\(long)&latitude=\(lat)&radius=\(rad)")
        let session = NSURLSession.sharedSession()
        let dataTask = session.dataTaskWithURL(url!, completionHandler: { (data: NSData!, response:NSURLResponse!, error:NSError!) -> Void in
                //do something
                if let json: NSArray = NSJSONSerialization.JSONObjectWithData(data, options: NSJSONReadingOptions.MutableContainers, error: nil) as? NSArray {//NSDictionary {
                    for item in json {
                        var i = item["id"]
                        println("HEY \(i)")
                    }
                }
            })
        
        /*
        [
            {
            "id":"1",
            "user_id":"1",
            "longitude":"-84.5155",
            "latitude":"39.132",
            "time_created":"2015-05-16 14:53:00",
            "expires":"2016-05-17 23:53:00",
            "additional_instructions":"Go to the 8th floor of Baldwin hall"
            }
        ]
        */


        // make pins for each output from server
        //var theAnnotation = MKPointAnnotation()
        //theAnnotation.coordinate = theLoc
        //theAnnotation.title = "Church"
        //theAnnotation.subtitle = "A famous church"
        
        //self.map.addAnnotation(theAnnotation)
    }
    
    override func prepareForSegue(segue: UIStoryboardSegue, sender: AnyObject?) {
        let controller = segue.destinationViewController as! SubmitViewController
        controller.long = long
        controller.lat = lat
        controller.rad = rad
    }
    
}

