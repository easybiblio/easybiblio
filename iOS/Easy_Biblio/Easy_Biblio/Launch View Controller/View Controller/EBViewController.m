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
#import "EBViewController.h"
#import "EBConstants.h"
#import "EBSearchResultsCustomCellTableViewCell.h"
#import "EBServiceLayer.h"
/**************************************************************************************/
#pragma mark - Interface
/**************************************************************************************/
@interface EBViewController ()

@end

/**************************************************************************************/
#pragma mark - Implementation
/**************************************************************************************/
@implementation EBViewController


/**************************************************************************************/
#pragma mark - View Lifecycle
/**************************************************************************************/
- (void)viewDidLoad {
    [super viewDidLoad];
    // Do any additional setup after loading the view, typically from a nib.
    
    /* Title of the page */
    self.title = STR_LAUNCH_PAGE_TITLE;
}

- (void)didReceiveMemoryWarning {
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

/**************************************************************************************/
#pragma mark - Table View Delegates
/**************************************************************************************/
#warning Hard-coded data
- (NSInteger)tableView:(UITableView *)tableView numberOfRowsInSection:(NSInteger)section
{
    /* Return the actual number of contents to be returned from the webservice. */
    return 10;
}

- (UITableViewCell *)tableView:(UITableView *)tableView cellForRowAtIndexPath:(NSIndexPath *)indexPath
{
    EBSearchResultsCustomCellTableViewCell *cell = [tableView dequeueReusableCellWithIdentifier:STR_SEARCH_CELL_IDENTIFIER];
    
    cell.lblBookTitle.text = @"Ouvres Pothumes";
    cell.lblAuthor.text = @"Allen Kardec";
    cell.lblCode.text = @"01.40.20";
    
    return cell;
}

/**************************************************************************************/
#pragma mark - Text Field Delegates
/**************************************************************************************/
- (BOOL)textFieldShouldReturn:(UITextField *)textField
{
    if([self.txtSearch isFirstResponder])
    {
        [self.txtSearch resignFirstResponder];
    }
    return YES;
}

/**************************************************************************************/
#pragma mark - Actions
/**************************************************************************************/
- (IBAction)btnSearchTapped:(id)sender
{
    /* Call the webservice here. */
    
    /* Update the table view contents. */
    
    /* Also need to handle the negative scenario. */
    
    /* Need to add the reachability class. */
    
    /* sample test */
    EBServiceLayer *objEBServiceLayer = [[EBServiceLayer alloc]init];
    [objEBServiceLayer getCompleteListOfAvailableBooks];
}

@end
