/*!
 * @file EBBook
 *
 * @author SMRT
 *
 * @section Licence
 * Under MIT License
 *
 * @section Description
 * Model class for the book object
 *
 * @section Version 1.0
 *
 */
/**************************************************************************************/
#pragma mark - Imported Classes
/**************************************************************************************/
#import <Foundation/Foundation.h>

/**************************************************************************************/
#pragma mark - Setters & Getters
/**************************************************************************************/
@interface EBBook : NSObject

/* Book Id */
@property (nonatomic, strong) NSString *strId;

/* Title */
@property (nonatomic, strong) NSString *strTitle;

/* Book Author */
@property (nonatomic, strong) NSString *strAuthor;

/* Co-Author */
@property (nonatomic, strong) NSString *strCoAuthor;

/* Book Category Id */
@property (nonatomic, strong) NSString *strCategoryId;

/* Book Cover URL */
@property (nonatomic, strong) NSString *strCoverURL;

/* Creation ID */
@property (nonatomic, strong) NSString *strCreationDate;

/* Book Description */
@property (nonatomic, strong) NSString *strDescription;

/* Editor */
@property (nonatomic, strong) NSString *strEditor;

/* Book Language */
@property (nonatomic, strong) NSString *strLanguage;

/* Lending Id */
@property (nonatomic, strong) NSString *strLendingId;

/* Book lended or not */
@property (nonatomic, assign) BOOL *blLended;

/* Book Notes */
@property (nonatomic, strong) NSString *strNotes;

/* Book Type */
@property (nonatomic, strong) NSString *strTypeName;

/* Book Type Id */
@property (nonatomic, strong) NSString *strTypeId;

/* Publication Date */
@property (nonatomic, strong) NSString *strPublicationDate;

/**************************************************************************************/
#pragma mark - Designated Initializer
/**************************************************************************************/
- (id)initWithResponse:(NSDictionary *)dict;

@end
