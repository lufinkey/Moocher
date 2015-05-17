//
//  LoginViewController.swift
//  FreeFood
//
//  Created by Adam Loeb on 5/16/15.
//  Copyright (c) 2015 Fopte. All rights reserved.
//

import UIKit

class LoginViewController: UIViewController {
    
    override func viewDidLoad() {
        super.viewDidLoad()
        
    }
    
    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
        // Dispose of any resources that can be recreated.
    }
    
    @IBOutlet weak var user_text: UITextField!
    @IBOutlet weak var pass_text: UITextField!
    @IBOutlet weak var button: UIButton!
    
    @IBAction func buttonPressed(sender: AnyObject) {
        //println("Hello world")
    }
    
    @IBAction func editEmail(sender: AnyObject) {
    }
    @IBAction func editPassword(sender: AnyObject) {
    }
}

