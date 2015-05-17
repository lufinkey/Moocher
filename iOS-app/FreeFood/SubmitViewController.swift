//
//  SubmitViewController.swift
//  FreeFood
//
//  Created by Adam Loeb on 5/16/15.
//  Copyright (c) 2015 Fopte. All rights reserved.
//

import UIKit
import Foundation

class SubmitViewController: UIViewController {
    
    var long = -84.5155;
    var lat = 39.132;
    var rad = 3000;
    
    override func viewDidLoad() {
        super.viewDidLoad()
        
    }
    
    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
        // Dispose of any resources that can be recreated.
    }
    
    @IBOutlet weak var content: UITextField!
    @IBOutlet weak var comment: UITextField!
    
    @IBAction func submitPressed(sender: AnyObject) {
        
        // TODO add web submit stuff
        var dict = "username=root&password=deadbabies&longitude=\(long)&latitude=\(lat)&lifespan=60&tags=[\"\(content.text)\"]&additional_instructions=\(comment.text)"
        self.post(dict, url: "http://moocher.atwebpages.com/api/v1/addlocation.php") { (succeeded: Bool, msg: String) -> () in
            if(succeeded) {
                //println("Success");
            }
            else {
                //println("Failed");
            }
        }
        
        sleep(1)
        
        self.navigationController?.popViewControllerAnimated(true)
    }
    
    
    
    func post(params : String, url : String, postCompleted : (succeeded: Bool, msg: String) -> ()) {
        var request = NSMutableURLRequest(URL: NSURL(string: url)!)
        var session = NSURLSession.sharedSession()
        request.HTTPMethod = "POST"
        
        var err: NSError?
        request.HTTPBody = params.dataUsingEncoding(NSUTF8StringEncoding)
        //request.addValue("application/json", forHTTPHeaderField: "Content-Type")
        //request.addValue("application/json", forHTTPHeaderField: "Accept")
        
        var task = session.dataTaskWithRequest(request, completionHandler: {data, response, error -> Void in
            //println(data)
            //println("Response: \(response)")
            var strData = NSString(data: data, encoding: NSUTF8StringEncoding)
            //println("Body: \(strData)")
            
            var json = NSJSONSerialization.JSONObjectWithData(data, options: .MutableLeaves, error: &err) as? NSDictionary
            
            var msg = "No message"
            
            // Did the JSONObjectWithData constructor return an error? If so, log the error to the console
            if(err != nil) {
                //println(err!.localizedDescription)
                let jsonStr = NSString(data: data, encoding: NSUTF8StringEncoding)
                //println("Error could not parse JSON: '\(jsonStr)'")
                postCompleted(succeeded: false, msg: "Error")
            }
            else {
                //println("Success: woo")
                postCompleted(succeeded: true, msg: "Logged in.")

            }
        })
        
        task.resume()
    }
}