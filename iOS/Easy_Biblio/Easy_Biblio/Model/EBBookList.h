/*!
 * @file EBBook
 *
 * @author SMRT
 *
 * @section Licence
 * Under MIT License
 *
 * @section Description
 * Model class containing the list of books.
 *
 * @section Version 1.0
 *
 */
/**************************************************************************************/
#pragma mark - Imported Classes
/**************************************************************************************/
#import <Foundation/Foundation.h>

/**************************************************************************************/
#pragma mark - Getters & Setters
/**************************************************************************************/
@interface EBBookList : NSObject

@property (nonatomic, strong) NSArray *arrBooks;

/**************************************************************************************/
#pragma mark - Designated Initializer
/**************************************************************************************/
-(id)initWithResponse:(NSArray *)response;

@end
