/*!
 * @file EBBookDetailsViewController
 *
 * @author SMRT
 *
 * @section Licence
 * Under MIT License
 *
 * @section Description
 * This class makes acts as the service layer. It makes the connection & parses the results.
 *
 * @section Version 1.0
 *
 */
/**************************************************************************************/
#pragma mark - Imported Classes
/**************************************************************************************/
#import <Foundation/Foundation.h>

/**************************************************************************************/
#pragma mark - Protocol
/**************************************************************************************/

@protocol EBServiceProtocol <NSObject>

-(void)listOfBooks:(NSArray *)books;

@end

/**************************************************************************************/
#pragma mark - Interface
/**************************************************************************************/
@interface EBServiceLayer : NSObject

@property (nonatomic, weak) id<EBServiceProtocol> delegate;

- (void)getCompleteListOfAvailableBooks;

@end
