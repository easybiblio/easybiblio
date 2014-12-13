/*!
 * @file EBViewController
 *
 * @author SMRT
 *
 * @section Licence
 * Under MIT License
 *
 * @section Description
 * First View Controller
 *
 * @section Version 1.0
 *
 */
/**************************************************************************************/
#pragma mark - Imported Classes
/**************************************************************************************/
#import <UIKit/UIKit.h>

@interface EBViewController : UIViewController<UITableViewDataSource, UITableViewDelegate, UITextFieldDelegate>

@property (nonatomic, weak) IBOutlet UITextField *txtSearch;
@property (nonatomic, weak) IBOutlet UIButton *btnSearch;

/**************************************************************************************/
#pragma mark - Actions
/**************************************************************************************/

- (IBAction)btnSearchTapped:(id)sender;

@end

