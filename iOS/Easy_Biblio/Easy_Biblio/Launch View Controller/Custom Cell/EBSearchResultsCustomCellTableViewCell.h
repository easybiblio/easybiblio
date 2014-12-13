/*!
 * @file EBSearchResultsCustomCellTableViewCell
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

@interface EBSearchResultsCustomCellTableViewCell : UITableViewCell

@property (nonatomic, weak) IBOutlet UILabel *lblBookTitle;
@property (nonatomic, weak) IBOutlet UILabel *lblAuthor;
@property (nonatomic, weak) IBOutlet UILabel *lblCode;

@end
